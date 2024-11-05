<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
    <!-- Même CSS que tvshows.php -->
</head>
<body>
    <nav>
        <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
        <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
    </nav>
    
    <h1>Popular Movies</h1>
    <div class="content-grid">
        <?php foreach ($movies['results'] as $movie): ?>
            <div class="content-card">
                <h2><?= htmlspecialchars($movie['title']) ?></h2>
                <p><?= htmlspecialchars($movie['overview']) ?></p>
                <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html> 