<?php
// controllers/MovieController.php
require_once '../models/Movie.php';

class MovieController {
    private $movieModel;
    private $apiBaseUrl;
    private $apiKey;

    public function __construct() {
        $this->movieModel = new Movie();
        $this->apiBaseUrl = TMDB_API_BASE_URL;
        $this->apiKey = TMDB_API_KEY;
    }

    public function showPopularMovies() {
        $movies = $this->movieModel->getPopularMovies();
        require '../views/home.php';
    }

    public function details($id) {
        try {
            // Build the API URL for movie details
            $url = $this->apiBaseUrl . '/movie/' . $id . '?api_key=' . $this->apiKey . '&append_to_response=credits';

            // Fetch the movie details with error handling
            $response = @file_get_contents($url);
            if ($response === false) {
                throw new Exception('Failed to fetch movie details');
            }

            $movieDetails = json_decode($response, true);
            if (!$movieDetails || isset($movieDetails['success']) && $movieDetails['success'] === false) {
                throw new Exception('Invalid movie data received');
            }

            // Load the view and pass the movie details
            require_once __DIR__ . '/../views/moviesDetails.php';
        } catch (Exception $e) {
            // Handle the error - you might want to show an error view
            $error = $e->getMessage();
            require_once __DIR__ . '/../views/error.php';
        }
    }
}
