<?php
namespace App\Controllers;

use App\Models\Movie;
use Exception;

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
}