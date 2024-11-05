<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular TV Shows</title>
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
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .search-bar {
            display: flex;
            width: 100%;
            max-width: 400px;
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

        .show-poster img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .rating {
            color: #ffd700;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<nav class="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
                <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
            </div>
            <!-- Search Form -->
            <form action="index.php" method="get" class="search-bar d-flex">
                <input type="hidden" name="controller" value="movie">
                <input type="hidden" name="action" value="search">
                <input type="text" name="query" class="form-control" placeholder="Search for a movie..." required>
                <button type="submit" class="btn btn-danger ms-2">Search</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="display-4 mb-4">Popular TV Shows</h1>
        <div class="content-grid">
            <?php foreach ($tvShows['results'] as $show): ?>
                <div class="content-card">
                    <?php if (!empty($show['poster_path'])): ?>
                        <div class="show-poster">
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($show['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($show['name']); ?>" 
                                 class="img-fluid">
                        </div>
                    <?php endif; ?>
                    <h2><?= htmlspecialchars($show['name']) ?></h2>
                    <p><?= htmlspecialchars($show['overview']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="index.php?controller=movie&action=details&id=<?= $show['id'] ?>&type=tv">
                            View Details
                        </a>
                        <?php if (!empty($show['vote_average'])): ?>
                            <span class="rating"><?= number_format($show['vote_average'], 1) ?>/10</span>
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
