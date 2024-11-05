<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
        }

        .navbar {
            background-color: #181818;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .navbar a:hover {
            background-color: #232323;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .content-card {
            background-color: #181818;
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.2s;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .content-card h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .content-card p {
            color: #aaaaaa;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .content-card a {
            background-color: #e50914;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }

        .content-card a:hover {
            background-color: #f40612;
            color: white;
        }

        .movie-poster img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
            <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="display-4 mb-4">Popular Movies</h1>
        <div class="content-grid">
            <?php foreach ($movies['results'] as $movie): ?>
                <div class="content-card">
                    <?php if (!empty($movie['poster_path'])): ?>
                        <div class="movie-poster">
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>" 
                                 class="img-fluid">
                        </div>
                    <?php endif; ?>
                    <h2><?= htmlspecialchars($movie['title']) ?></h2>
                    <p><?= htmlspecialchars($movie['overview']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie">
                            View Details
                        </a>
                        <?php if (!empty($movie['vote_average'])): ?>
                            <span class="rating"><?= number_format($movie['vote_average'], 1) ?>/10</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 