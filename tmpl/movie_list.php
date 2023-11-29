<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    #tmdb-results-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .tmdb-movie-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        background-color: rgba(255, 255, 255, 1); /* Transparent background */
    }

    .tmdb-movie-item img {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
        transition: transform 0.3s ease-in-out;
    }

    .tmdb-movie-item:hover {
        transform: scale(1.05);
    }

    .tmdb-movie-info {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        display: none;
        padding: 10px;
        background-color: #fff;
        border-radius: 0 0 10px 10px;
    }

    .tmdb-movie-info h2 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
    }

    .tmdb-movie-info p {
        margin-top: 10px;
        font-size: 0.9rem;
        color: #555;
    }

    .read-more-btn {
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
    }

    #tmdb-search-form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    #tmdb-search-input {
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
    }

    #tmdb-search-button {
        padding: 10px;
        font-size: 1rem;
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    #tmdb-search-button:hover {
        background-color: #0056b3;
    }
</style>

<form method="get" id="tmdb-search-form">
        <input type="text" name="search" id="tmdb-search-input" placeholder="Search for movies...">
        <button type="submit" id="tmdb-search-button">Search</button>
    </form>

    <div id="tmdb-results-container">
        <?php if (isset($tmdbData['results'])) : ?>
            <?php foreach ($tmdbData['results'] as $movie) : ?>
                <a href="index.php?id=<?php echo $movie['id']; ?>" class="tmdb-movie-item">
                    <?php include __DIR__ . '/default_item.php'; ?>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>

<script>
   async function fetchMovieSuggestions(query) {
    try {
        const apiKey = '2c756e926a0cbfda8afacf65d9cb9bb1';
        const baseUrl = 'https://api.themoviedb.org/3';
        
        const response = await fetch(`${baseUrl}/search/movie?api_key=${apiKey}&query=${encodeURIComponent(query)}`);
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        return data.results;
    } catch (error) {
        console.error('Error fetching movie suggestions:', error.message);
        return [];
    }
}

function displayMovies(results) {
    const resultsContainer = document.getElementById('tmdb-results-container');
    resultsContainer.innerHTML = ''; // Clear previous results
    
    if (results.length > 0) {
        results.forEach(movie => {
            const movieItem = document.createElement('a');
            movieItem.href = `index.php?id=${movie.id}`;
            movieItem.className = 'tmdb-movie-item';

            // Create and append an image element
            const movieImage = document.createElement('img');
            movieImage.src = `https://image.tmdb.org/t/p/w200${movie.poster_path}`;
            movieImage.alt = movie.title; // Set alt attribute for accessibility
            movieItem.appendChild(movieImage);

            // Create and append movie info container (optional)
            const movieInfo = document.createElement('div');
            movieInfo.className = 'tmdb-movie-info';

            // Create and append heading for movie title
            const movieTitleHeading = document.createElement('h2');
            movieTitleHeading.textContent = movie.title;
            movieInfo.appendChild(movieTitleHeading);

            // Create and append paragraph for movie overview
            const movieOverviewParagraph = document.createElement('p');
            movieOverviewParagraph.textContent = movie.overview;
            movieInfo.appendChild(movieOverviewParagraph);

            // Create and append "Read More" button (optional)
            const readMoreBtn = document.createElement('button');
            readMoreBtn.className = 'read-more-btn';
            readMoreBtn.textContent = 'Read More';
            readMoreBtn.addEventListener('click', () => {
                // Implement logic to show more details if needed
                console.log('Read More clicked for movie:', movie);
            });
            movieInfo.appendChild(readMoreBtn);

            // Append movie info container to movie item
            movieItem.appendChild(movieInfo);

            resultsContainer.appendChild(movieItem);
        });
    } else {
        resultsContainer.innerHTML = '<p>No results found.</p>';
    }
}

document.getElementById('tmdb-search-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const searchInput = document.getElementById('tmdb-search-input');
    const query = searchInput.value.trim();

    if (query !== '') {
        // Fetch and display movies based on the search query
        const searchResults = await fetchMovieSuggestions(query);
        displayMovies(searchResults);

        // Clear the input field
        searchInput.value = '';
    } else {
        alert('Please enter a search query.');
    }
});

</script>
