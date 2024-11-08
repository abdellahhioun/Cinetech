<?php
namespace App\Controllers;

use App\Models\Movie;
use Exception;
use PDO;

class MovieController {
    private $movieModel;
    private $apiBaseUrl;
    private $apiKey;
    private $db;

    public function __construct() {
        $this->movieModel = new Movie();
        $this->apiBaseUrl = TMDB_API_BASE_URL;
        $this->apiKey = TMDB_API_KEY;

        // Database connection
        $this->db = new PDO('mysql:host=localhost;dbname=cinetech', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function showPopularMovies() {
        $movies = $this->movieModel->getPopularMovies();
        // Randomize and get first 5 movies for carousel
        $results = $movies['results'];
        shuffle($results);
        $movies['results'] = $results;
        
        require __DIR__ . '/../../views/movies.php';
    }

    public function showPopularTVShows() {
        $tvShows = $this->movieModel->getPopularTVShows(2);
        // Randomize the results for carousel
        $results = $tvShows['results'];
        shuffle($results);
        $tvShows['results'] = $results;
        
        require __DIR__ . '/../../views/tvshows.php';
    }

    public function details($id, $type = 'movie') {

        try {
            if ($type === 'person') {
                // Fetch person/actor details with movie credits and TV credits
                $url = $this->apiBaseUrl . '/person/' . $id . '?api_key=' . $this->apiKey . '&append_to_response=movie_credits,tv_credits';
                
                $response = @file_get_contents($url);
                if ($response === false) {
                    throw new Exception('Failed to fetch actor details');
                }

                $details = json_decode($response, true);
                if (!$details || isset($details['success']) && $details['success'] === false) {
                    throw new Exception('Invalid data received');
                }

                // Sort movies by popularity (descending)
                if (isset($details['movie_credits']['cast'])) {
                    usort($details['movie_credits']['cast'], function($a, $b) {
                        return ($b['popularity'] ?? 0) <=> ($a['popularity'] ?? 0);
                    });
                }

                // Sort TV shows by popularity (descending)
                if (isset($details['tv_credits']['cast'])) {
                    usort($details['tv_credits']['cast'], function($a, $b) {
                        return ($b['popularity'] ?? 0) <=> ($a['popularity'] ?? 0);
                    });
                }

                // Fetch reviews for the movie
                $reviews = $this->movieModel->getReviews($id);

                // Filter to get reviews from 3 unique users
                $uniqueReviews = [];
                foreach ($reviews as $review) {
                    if (!isset($uniqueReviews[$review['author']]) && count($uniqueReviews) < 3) {
                        $uniqueReviews[$review['author']] = $review;
                    }
                }

                // Convert associative array back to indexed array
                $reviews = array_values($uniqueReviews);

                // Fetch comments for the movie
                $comments = $this->getComments($id);

                require __DIR__ . '/../../views/actorDetails.php';
                return;
            }

            // Update the API call to include credits, videos, and genres
            $url = $this->apiBaseUrl . '/' . $type . '/' . $id . '?api_key=' . $this->apiKey 
                 . '&append_to_response=credits,videos,similar,recommendations'
                 . '&include_video=true';
            
            $response = @file_get_contents($url);
            if ($response === false) {
                throw new Exception('Failed to fetch details');
            }

            $details = json_decode($response, true);
            if (!$details || isset($details['success']) && $details['success'] === false) {
                throw new Exception('Invalid data received');
            }

            // Sort cast by order/popularity if needed
            if (!empty($details['credits']['cast'])) {
                usort($details['credits']['cast'], function($a, $b) {
                    return ($a['order'] ?? PHP_INT_MAX) - ($b['order'] ?? PHP_INT_MAX);
                });
            }

            // Get the first trailer if available
            if (!empty($details['videos']['results'])) {
                $trailers = array_filter($details['videos']['results'], function($video) {
                    return $video['type'] === 'Trailer' && $video['site'] === 'YouTube';
                });
                if (!empty($trailers)) {
                    $details['videos']['results'] = array_values($trailers);
                }
            }

            $viewFile = ($type === 'movie' ? 'movieDetails.php' : 'tvshowDetails.php');
            $viewPath = __DIR__ . '/../../views/' . $viewFile;
            
            if (!file_exists($viewPath)) {
                throw new Exception("View file not found: {$viewFile}");
            }

            // Fetch reviews for the movie
            $reviews = $this->movieModel->getReviews($id);

            // Filter to get reviews from 3 unique users
            $uniqueReviews = [];
            foreach ($reviews as $review) {
                if (!isset($uniqueReviews[$review['author']]) && count($uniqueReviews) < 3) {
                    $uniqueReviews[$review['author']] = $review;
                }
            }

            // Convert associative array back to indexed array
            $reviews = array_values($uniqueReviews);

            // Fetch comments for the movie
            $comments = $this->getComments($id);

            require $viewPath;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $errorPath = __DIR__ . '/../../views/error.php';
            
            if (!file_exists($errorPath)) {
                die('Error: ' . htmlspecialchars($error));
            }
            
            require $errorPath;
        }
    }

    public function search() {
        // Get the search query from the URL
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';

        // Check if the query is not empty
        if (!empty($query)) {
            try {
                // Fetch search results from TMDB API
                $url = $this->apiBaseUrl . '/search/movie?api_key=' . $this->apiKey . '&query=' . urlencode($query);
                $response = @file_get_contents($url);

                // Check if the response is valid
                if ($response === false) {
                    throw new Exception('Failed to fetch search results');
                }

                // Decode the JSON response
                $searchResults = json_decode($response, true);

                // Check if the search results are valid
                if (!$searchResults || isset($searchResults['success']) && $searchResults['success'] === false) {
                    throw new Exception('Invalid data received');
                }

                // Pass search results to the view
                require __DIR__ . '/../../views/searchResults.php';
            } catch (Exception $e) {
                // Handle any exceptions and show an error page
                $error = $e->getMessage();
                require __DIR__ . '/../../views/error.php';
            }
        } else {
            // If the query is empty, redirect to popular movies
            header('Location: index.php?controller=movie&action=showPopularMovies');
            exit;
        }
    }

    public function searchTVShows() {
        $query = $_GET['query'] ?? '';
        if ($query === '') {
            throw new Exception('Query parameter is missing');
        }

        $url = $this->apiBaseUrl . '/search/tv?api_key=' . $this->apiKey . '&query=' . urlencode($query);
        
        $response = @file_get_contents($url);
        if ($response === false) {
            throw new Exception('Failed to fetch search results');
        }

        $tvShows = json_decode($response, true);
        if (!$tvShows || isset($tvShows['success']) && $tvShows['success'] === false) {
            throw new Exception('Invalid data received');
        }

        require __DIR__ . '/../../views/tvshows.php';
    }

    public function showProfile() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        // Fetch user data from the database
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['user']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../../views/profile.php';
    }

    public function updateProfilePicture() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        $profilePicture = $_FILES['profile_picture'] ?? null;

        if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/';
            $profilePicturePath = 'uploads/' . basename($profilePicture['name']);
            move_uploaded_file($profilePicture['tmp_name'], $uploadDir . basename($profilePicture['name']));

            // Update the user's profile picture in the database
            $stmt = $this->db->prepare("UPDATE users SET profile_picture = :profile_picture WHERE username = :username");
            $stmt->bindParam(':profile_picture', $profilePicturePath);
            $stmt->bindParam(':username', $_SESSION['user']);
            $stmt->execute();
        }

        header('Location: index.php?controller=user&action=showProfile');
        exit;
    }

    public function toggleFavorite() {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Please login to add favorites']);
            exit;
        }

        try {
            $contentId = $_POST['content_id'] ?? null;
            $contentType = $_POST['content_type'] ?? null;
            $title = $_POST['title'] ?? null;
            $posterPath = $_POST['poster_path'] ?? null;

            if (!$contentId || !$contentType || !$title) {
                throw new Exception('Missing required parameters');
            }

            // Get user ID
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->execute([':username' => $_SESSION['user']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception('User not found');
            }

            // Check if already favorited
            $stmt = $this->db->prepare("
                SELECT id FROM favorites 
                WHERE user_id = :user_id 
                AND content_id = :content_id 
                AND content_type = :content_type
            ");
            $stmt->execute([
                ':user_id' => $user['id'],
                ':content_id' => $contentId,
                ':content_type' => $contentType
            ]);

            if ($stmt->fetch()) {
                // Remove from favorites
                $stmt = $this->db->prepare("
                    DELETE FROM favorites 
                    WHERE user_id = :user_id 
                    AND content_id = :content_id 
                    AND content_type = :content_type
                ");
                $stmt->execute([
                    ':user_id' => $user['id'],
                    ':content_id' => $contentId,
                    ':content_type' => $contentType
                ]);
                echo json_encode(['success' => true, 'action' => 'removed']);
            } else {
                // Add to favorites
                $stmt = $this->db->prepare("
                    INSERT INTO favorites (user_id, content_id, content_type, title, poster_path) 
                    VALUES (:user_id, :content_id, :content_type, :title, :poster_path)
                ");
                $stmt->execute([
                    ':user_id' => $user['id'],
                    ':content_id' => $contentId,
                    ':content_type' => $contentType,
                    ':title' => $title,
                    ':poster_path' => $posterPath
                ]);
                echo json_encode(['success' => true, 'action' => 'added']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function getFavoriteStatus($contentId, $contentType) {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT f.id 
            FROM favorites f 
            JOIN users u ON f.user_id = u.id 
            WHERE u.username = :username 
            AND f.content_id = :content_id 
            AND f.content_type = :content_type
        ");
        
        $stmt->execute([
            ':username' => $_SESSION['user'],
            ':content_id' => $contentId,
            ':content_type' => $contentType
        ]);

        return $stmt->fetch() !== false;
    }

    public function getFavorites($username) {
        $stmt = $this->db->prepare("
            SELECT f.* 
            FROM favorites f
            INNER JOIN users u ON f.user_id = u.id
            WHERE u.username = :username
            ORDER BY f.created_at DESC
        ");
        $stmt->execute([':username' => $username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function showTopRatedMovies() {
        try {
            $url = $this->apiBaseUrl . '/movie/top_rated?api_key=' . $this->apiKey;
            $response = @file_get_contents($url);
            
            if ($response === false) {
                throw new Exception('Failed to fetch top rated movies');
            }

            $movies = json_decode($response, true);
            if (!$movies || isset($movies['success']) && $movies['success'] === false) {
                throw new Exception('Invalid data received');
            }

            require __DIR__ . '/../../views/topRated.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/error.php';
        }
    }

    public function showUpcomingMovies() {
        try {
            $url = $this->apiBaseUrl . '/movie/upcoming?api_key=' . $this->apiKey;
            $response = @file_get_contents($url);
            
            if ($response === false) {
                throw new Exception('Failed to fetch upcoming movies');
            }

            $movies = json_decode($response, true);
            if (!$movies || isset($movies['success']) && $movies['success'] === false) {
                throw new Exception('Invalid data received');
            }

            require __DIR__ . '/../../views/upcoming.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/error.php';
        }
    }

    public function showNowPlayingMovies() {
        try {
            $url = $this->apiBaseUrl . '/movie/now_playing?api_key=' . $this->apiKey;
            $response = @file_get_contents($url);
            
            if ($response === false) {
                throw new Exception('Failed to fetch now playing movies');
            }

            $movies = json_decode($response, true);
            if (!$movies || isset($movies['success']) && $movies['success'] === false) {
                throw new Exception('Invalid data received');
            }

            require __DIR__ . '/../../views/nowPlaying.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/error.php';
        }
    }

    public function addComment() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = $_POST['movie_id'] ?? null;
            $comment = $_POST['comment'] ?? null;
            $parentId = $_POST['parent_id'] ?? null;
            $username = $_SESSION['user'];

            if ($movieId && $comment) {
                try {
                    $stmt = $this->db->prepare(
                        "INSERT INTO comments (movie_id, user_name, comment, parent_id) 
                         VALUES (:movie_id, :user_name, :comment, :parent_id)"
                    );
                    $stmt->execute([
                        ':movie_id' => $movieId,
                        ':user_name' => $username,
                        ':comment' => $comment,
                        ':parent_id' => $parentId
                    ]);

                    header("Location: index.php?controller=movie&action=details&id=$movieId");
                    exit;
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function getComments($movieId) {
        $stmt = $this->db->prepare(
            "SELECT c.*, 
                    (SELECT COUNT(*) FROM comments r WHERE r.parent_id = c.id) as reply_count
             FROM comments c 
             WHERE c.movie_id = :movie_id AND c.parent_id IS NULL 
             ORDER BY c.created_at DESC"
        );
        $stmt->execute([':movie_id' => $movieId]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($comments as &$comment) {
            $stmt = $this->db->prepare(
                "SELECT * FROM comments 
                 WHERE parent_id = :parent_id 
                 ORDER BY created_at ASC"
            );
            $stmt->execute([':parent_id' => $comment['id']]);
            $comment['replies'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $comments;
    }
}