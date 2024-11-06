<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular TV Shows</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        /* Remove duplicate styles and keep only the movies.php version */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .content-card {
            background-color: #181818;
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content-card:hover {
            transform: translateY(-5px);
            text-decoration: none;
            color: inherit;
        }

        .content-card img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .content-card:hover img {
            transform: scale(1.05);
        }

        .content-card h2 {
            font-size: 1.2rem;
            margin: 1rem 0;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .content-card p {
            color: #b3b3b3;
            font-size: 0.9rem;
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            margin-bottom: 0;
            flex-grow: 1;
        }

        .show-poster {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 1rem;
            aspect-ratio: 2/3;
            width: 100%;
        }

        .show-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.3s ease;
        }

        .rating-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 10px;
            border-radius: 20px;
            color: #ffd700;
            font-weight: bold;
            z-index: 1;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            padding: 0;
        }

        .favorite-btn i {
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .favorite-btn.active {
            background: rgba(229, 9, 20, 0.9);
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background: rgba(229, 9, 20, 0.9);
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
                <!-- Profile Icon -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?controller=user&action=showProfile" class="btn btn-secondary">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                <?php else: ?>
                    <a href="index.php?controller=user&action=showLoginForm" class="btn btn-secondary">Login</a>
                <?php endif; ?>
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
                <a href="index.php?controller=movie&action=details&id=<?= $show['id'] ?>&type=tv" class="content-card">
                    <div class="show-poster">
                        <?php if (!empty($show['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($show['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($show['name']); ?>" 
                                 class="img-fluid">
                            <?php if (!empty($show['vote_average'])): ?>
                                <span class="rating-badge">
                                    <i class="fas fa-star" style="color: #ffd700;"></i>
                                    <?= number_format($show['vote_average'], 1) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <button class="favorite-btn <?php echo $this->getFavoriteStatus($show['id'], 'tv') ? 'active' : ''; ?>"
                                        onclick="toggleFavorite(event, this, <?php echo $show['id']; ?>, 'tv', '<?php echo addslashes($show['name']); ?>', '<?php echo $show['poster_path']; ?>')">
                                    <i class="fas fa-heart"></i>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <h2><?= htmlspecialchars($show['name']) ?></h2>
                    <p><?= htmlspecialchars($show['overview']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleFavorite(event, button, contentId, contentType, title, posterPath) {
        event.preventDefault(); // Prevent the card click event
        event.stopPropagation(); // Prevent event bubbling
        
        fetch('index.php?controller=movie&action=toggleFavorite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `content_id=${contentId}&content_type=${contentType}&title=${encodeURIComponent(title)}&poster_path=${encodeURIComponent(posterPath)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.classList.toggle('active');
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>
