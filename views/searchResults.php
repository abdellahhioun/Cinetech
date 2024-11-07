<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/styles.css">
    <link rel="stylesheet" href="../src/movies.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'partials/navbar.php'; ?>
    
    <div class="container">
        <h1 class="display-4 mb-4">Search Results</h1>
        <?php if (!empty($searchResults['results'])): ?>
            <div class="content-grid">
                <?php foreach ($searchResults['results'] as $movie): ?>
                    <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie" class="content-card">
                        <div class="movie-poster">
                            <?php if (!empty($movie['poster_path'])): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
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
        <?php else: ?>
            <p>No results found for your search.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFavorite(event, button, contentId, contentType, title, posterPath) {
            event.preventDefault();
            event.stopPropagation();
            button.classList.toggle('active');

            fetch('index.php?controller=movie&action=toggleFavorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `content_id=${contentId}&content_type=${contentType}&title=${encodeURIComponent(title)}&poster_path=${encodeURIComponent(posterPath)}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    button.classList.toggle('active');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.classList.toggle('active');
            });
        }
    </script>

    <?php include 'partials/footer.php'; ?>
</body>
</html>
