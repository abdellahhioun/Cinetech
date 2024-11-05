<?php
namespace App\Models;

class Movie {
    private $apiBaseUrl;
    private $apiKey;

    public function __construct() {
        $this->apiBaseUrl = TMDB_API_BASE_URL;
        $this->apiKey = TMDB_API_KEY;
    }

    public function getPopularMovies($pages = 2) {
        return $this->fetchPopularContent('movie', $pages);
    }

    public function getPopularTVShows($pages = 2) {
        return $this->fetchPopularContent('tv', $pages);
    }

    private function fetchPopularContent($type, $pages) {
        $allContent = ['results' => []];
        
        for ($page = 1; $page <= $pages; $page++) {
            $url = $this->apiBaseUrl . '/' . $type . '/popular?api_key=' . $this->apiKey . '&page=' . $page;
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if ($data && isset($data['results'])) {
                $allContent['results'] = array_merge($allContent['results'], $data['results']);
            }
        }
        
        return $allContent;
    }
}
