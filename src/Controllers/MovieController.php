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
        $movies = $this->movieModel->getPopularMovies();
        require __DIR__ . '/../../views/home.php';
    }

    public function details($id) {
        try {
            $url = $this->apiBaseUrl . '/movie/' . $id . '?api_key=' . $this->apiKey . '&append_to_response=credits';
            
            $response = @file_get_contents($url);
            if ($response === false) {
                throw new Exception('Failed to fetch movie details');
            }

            $movieDetails = json_decode($response, true);
            if (!$movieDetails || isset($movieDetails['success']) && $movieDetails['success'] === false) {
                throw new Exception('Invalid movie data received');
            }

            require __DIR__ . '/../../views/moviesDetails.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/error.php';
        }
    }
} 