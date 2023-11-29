<?php
defined('_JEXEC') or die;

// Include the TMDb API key and base URL
const API_KEY = '2c756e926a0cbfda8afacf65d9cb9bb1';
const BASE_URL = 'https://api.themoviedb.org/3';

// Function to fetch a random page of TMDb popular movies
function fetchRandomMovieData() {
    $totalPages = 100; // Assume a maximum of 100 pages, adjust if needed
    $randomPage = mt_rand(1, $totalPages); // Generate a random page number

    $endpoint = '/movie/popular';
    $url = BASE_URL . $endpoint . '?api_key=' . API_KEY . '&page=' . $randomPage;

    // Make the API request
    $response = file_get_contents($url);

    if ($response === false) {
        // Handle the error, for example:
        die('Error fetching data from TMDb API');
    }

    $data = json_decode($response, true);

    if ($data === null) {
        // Handle JSON decoding error, for example:
        die('Error decoding JSON data from TMDb API');
    }

    return $data;
}

// Function to fetch detailed information about a specific movie
function fetchMovieDetails($movieId) {
    $endpoint = '/movie/' . $movieId;
    $url = BASE_URL . $endpoint . '?api_key=' . API_KEY;

    // Make the API request
    $response = file_get_contents($url);

    if ($response === false) {
        // Handle the error, for example:
        die('Error fetching data from TMDb API');
    }

    $data = json_decode($response, true);

    if ($data === null) {
        // Handle JSON decoding error, for example:
        die('Error decoding JSON data from TMDb API');
    }

    return $data;
}

// Check if movie details are requested
$movieId = isset($_GET['id']) ? $_GET['id'] : null;

if ($movieId !== null) {
    // Movie details are requested
    $movieDetails = fetchMovieDetails($movieId);
    require_once __DIR__ . '/tmpl/movie_details.php';
} else {
    // Fetch random popular movies
    $tmdbData = fetchRandomMovieData();
    require_once __DIR__ . '/tmpl/movie_list.php';
}
?>
