<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
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
            text-decoration: none;
            color: inherit;
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
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        .content-card p {
            color: #b3b3b3;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .movie-poster {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 1rem;
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

        /* Carousel Styles */
        #movieCarousel {
            margin-bottom: 2rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .carousel-content {
            position: relative;
            height: 500px;
        }

        .carousel-backdrop {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8) 40%, rgba(0, 0, 0, 0.95));
            padding: 100px 50px 50px;
        }

        .carousel-caption {
            position: relative;
            right: auto;
            bottom: auto;
            left: auto;
            text-align: left;
            padding: 0;
        }

        .carousel-caption h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .movie-overview {
            font-size: 1.1rem;
            max-width: 600px;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .carousel-details {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .carousel-details .rating {
            font-size: 1.2rem;
            color: #ffd700;
        }

        .carousel-details .btn {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #e50914;
            border: none;
            transition: all 0.3s ease;
        }

        .carousel-details .btn:hover {
            background-color: #ff0f1f;
            transform: translateY(-2px);
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .carousel-indicators button.active {
            background-color: #fff;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #movieCarousel:hover .carousel-control-prev,
        #movieCarousel:hover .carousel-control-next {
            opacity: 1;
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
    
    <div class="container mb-5">
        <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <?php 
                $firstFiveMovies = array_slice($movies['results'], 0, 5);
                foreach($firstFiveMovies as $index => $movie): ?>
                    <button type="button" 
                            data-bs-target="#movieCarousel" 
                            data-bs-slide-to="<?= $index ?>" 
                            class="<?= $index === 0 ? 'active' : '' ?>"
                            aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                            aria-label="Slide <?= $index + 1 ?>">
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Carousel items -->
            <div class="carousel-inner">
                <?php foreach($firstFiveMovies as $index => $movie): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="3000">
                        <div class="carousel-content">
                            <img src="https://image.tmdb.org/t/p/original<?= $movie['backdrop_path'] ?>" 
                                 class="carousel-backdrop" 
                                 alt="<?= htmlspecialchars($movie['title']) ?>">
                            <div class="carousel-overlay">
                                <div class="carousel-caption">
                                    <h2><?= htmlspecialchars($movie['title']) ?></h2>
                                    <p class="movie-overview"><?= htmlspecialchars($movie['overview']) ?></p>
                                    <div class="carousel-details">
                                        <span class="rating">
                                            <i class="fas fa-star"></i> 
                                            <?= number_format($movie['vote_average'], 1) ?>
                                        </span>
                                        <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie" 
                                           class="btn btn-primary">Watch Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#movieCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#movieCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    
    <div class="container">
        <h1 class="display-4 mb-4">Popular Movies</h1>
        <div class="content-grid">
            <?php foreach ($movies['results'] as $movie): ?>
                <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie" class="content-card">
                    <div class="movie-poster">
                        <?php if (!empty($movie['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>" 
                                 class="img-fluid">
                            <?php if (!empty($movie['vote_average'])): ?>
                                <span class="rating-badge">
                                    <i class="fas fa-star" style="color: #ffd700;"></i>
                                    <?= number_format($movie['vote_average'], 1) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <button class="favorite-btn <?php echo $this->getFavoriteStatus($movie['id'], 'movie') ? 'active' : ''; ?>"
                                        onclick="toggleFavorite(event, this, <?php echo $movie['id']; ?>, 'movie', '<?php echo addslashes($movie['title']); ?>', '<?php echo $movie['poster_path']; ?>')">
                                    <i class="fas fa-heart"></i>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <h2><?= htmlspecialchars($movie['title']) ?></h2>
                    <p><?= htmlspecialchars($movie['overview']) ?></p>
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