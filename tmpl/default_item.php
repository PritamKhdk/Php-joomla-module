<?php
defined('_JEXEC') or die;


$movieTitle = $movie['title'];
$movieImage = 'https://image.tmdb.org/t/p/w200' . $movie['poster_path']; 


?>

<div>
    <img src="<?php echo $movieImage; ?>" alt="<?php echo $movieTitle; ?>">
    <h3><?php echo $movieTitle; ?></h3>
   
</div>
