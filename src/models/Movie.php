<?php
namespace App\Models;

class Movie {
    private $apiBaseUrl;
    private $apiKey;

    public function __construct() {
        $this->apiBaseUrl = TMDB_API_BASE_URL;
        $this->apiKey = TMDB_API_KEY;
    }

    public function getPopularMovies() {
        $url = $this->apiBaseUrl . '/movie/popular?api_key=' . $this->apiKey;
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
