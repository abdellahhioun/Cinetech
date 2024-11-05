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
        $movies = $this->movieModel->getPopularMovies(2);
        require __DIR__ . '/../../views/movies.php';
    }

    public function showPopularTVShows() {
        $tvShows = $this->movieModel->getPopularTVShows(2);
        require __DIR__ . '/../../views/tvshows.php';
    }

    public function details($id, $type = 'movie') {
        try {
            $url = $this->apiBaseUrl . '/' . $type . '/' . $id . '?api_key=' . $this->apiKey . '&append_to_response=credits';
            
            $response = @file_get_contents($url);
            if ($response === false) {
                throw new Exception('Failed to fetch details');
            }

            $details = json_decode($response, true);
            if (!$details || isset($details['success']) && $details['success'] === false) {
                throw new Exception('Invalid data received');
            }

            $viewFile = ($type === 'movie' ? 'movieDetails.php' : 'tvshowDetails.php');
            $viewPath = __DIR__ . '/../../views/' . $viewFile;
            
            if (!file_exists($viewPath)) {
                throw new Exception("View file not found: {$viewFile}");
            }

            require $viewPath;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $errorPath = __DIR__ . '/../../views/error.php';
            
            if (!file_exists($errorPath)) {
                // Fallback if error view is missing
                die('Error: ' . htmlspecialchars($error));
            }
            
            require $errorPath;
        }
    }

    public function search() {
        $query = $_GET['query'] ?? '';

        if (!empty($query)) {
            try {
                // Fetch search results from TMDB API
                $url = $this->apiBaseUrl . '/search/movie?api_key=' . $this->apiKey . '&query=' . urlencode($query);
                $response = @file_get_contents($url);

                if ($response === false) {
                    throw new Exception('Failed to fetch search results');
                }

                $searchResults = json_decode($response, true);

                if (!$searchResults || isset($searchResults['success']) && $searchResults['success'] === false) {
                    throw new Exception('Invalid data received');
                }

                // Pass search results to the view
                require __DIR__ . '/../../views/searchResults.php';
            } catch (Exception $e) {
                $error = $e->getMessage();
                $errorPath = __DIR__ . '/../../views/error.php';
                if (!file_exists($errorPath)) {
                    die('Error: ' . htmlspecialchars($error));
                }
                require $errorPath;
            }
        } else {
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
}