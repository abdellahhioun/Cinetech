<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
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
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1800px;
            margin: 0 auto;
        }

        .content-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 2/3;
            transition: transform 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .movie-poster {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .content-card:hover .movie-poster img {
            transform: scale(1.1);
        }

        .movie-info {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0, 0, 0, 0.9) 0%,
                rgba(0, 0, 0, 0.6) 50%,
                rgba(0, 0, 0, 0.3) 100%
            );
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .content-card:hover .movie-info {
            opacity: 1;
        }

        .content-card h2 {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
            text-align: center;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .content-card:hover h2 {
            transform: translateY(0);
        }

        .rating-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #ffd700;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .content-card:hover .rating-badge {
            opacity: 1;
            transform: translateY(0);
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 6px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 2;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .favorite-btn i {
            color: #fff;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .content-card:hover .favorite-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .favorite-btn:hover {
            background: #e50914;
        }

        .favorite-btn.active {
            opacity: 1;
            background: #e50914;
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
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?controller=user&action=showProfile" class="btn btn-secondary">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                <?php else: ?>
                    <a href="index.php?controller=user&action=showLoginForm" class="btn btn-secondary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="display-4 mb-4">Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h1>
        
        <?php if (!empty($searchResults['results'])): ?>
            <div class="content-grid">
                <?php foreach ($searchResults['results'] as $movie): ?>
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
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
