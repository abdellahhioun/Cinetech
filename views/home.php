<!-- views/home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
    <link rel="stylesheet" href="/css/style.css">
    
</head>
<body>
    <h1>Popular Movies</h1>
    <div class="movies-grid">
        <?php foreach ($movies['results'] as $movie): ?>
            <div class="movie-card">
                <h2><?= htmlspecialchars($movie['title']) ?></h2>
                <p><?= htmlspecialchars($movie['overview']) ?></p>
                <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
