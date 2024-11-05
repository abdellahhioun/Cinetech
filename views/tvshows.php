<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular TV Shows</title>
    <link rel="stylesheet" href="/css/style.css">
    
</head>
<body>
    <nav>
        <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
        <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
    </nav>
    
    <h1>Popular TV Shows</h1>
    <div class="content-grid">
        <?php foreach ($tvShows['results'] as $show): ?>
            <div class="content-card">
                <h2><?= htmlspecialchars($show['name']) ?></h2>
                <p><?= htmlspecialchars($show['overview']) ?></p>
                <a href="index.php?controller=movie&action=details&id=<?= $show['id'] ?>&type=tv">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html> 