<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Rated Movies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/assets/styles.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="container">
        <h1 class="display-4 mb-4">Top Rated Movies</h1>
        <div class="content-grid">
            <?php foreach ($movies['results'] as $movie): ?>
                <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie" class="content-card">
                    <div class="movie-poster">
                        <?php if (!empty($movie['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <?php endif; ?>
                    </div>
                    
                    <div class="movie-info">
                        <h2><?= htmlspecialchars($movie['title']) ?></h2>
                    </div>

                    <?php if (!empty($movie['vote_average'])): ?>
                        <span class="rating-badge">
                            <i class="fas fa-star"></i>
                            <?= number_format($movie['vote_average'], 1) ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <button class="favorite-btn <?php echo $this->getFavoriteStatus($movie['id'], 'movie') ? 'active' : ''; ?>"
                                onclick="toggleFavorite(event, this, <?php echo $movie['id']; ?>, 'movie', '<?php echo addslashes($movie['title']); ?>', '<?php echo $movie['poster_path']; ?>')">
                            <i class="fas fa-heart"></i>
                        </button>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>
</html> 