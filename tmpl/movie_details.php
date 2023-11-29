<style>
   body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .movie-details-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 600px;
        width: 100%;
        padding: 30px 20px; /* Added more padding to the top */
        box-sizing: border-box;
        text-align: center;
    }

    .movie-details-container img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .movie-details-container h3 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .movie-details-container p {
        margin: 10px 0;
        font-size: 1rem;
        color: #555;
    }
</style>

<?php
$movieTitle = $movieDetails['title'];
$movieImage = 'https://image.tmdb.org/t/p/w200' . $movieDetails['poster_path'];
$movieDescription = $movieDetails['overview'];
$releaseDate = $movieDetails['release_date'];
?>

<div class="container">
    <div class="movie-details-container">
        <img src="<?php echo $movieImage; ?>" alt="<?php echo $movieTitle; ?>">
        <h3><?php echo $movieTitle; ?></h3>
        <p><strong>Release Date:</strong> <?php echo $releaseDate; ?></p>
        <p><?php echo $movieDescription; ?></p>
    </div>
</div>
