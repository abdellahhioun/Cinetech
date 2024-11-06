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

        /* Overlay that appears on hover */
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

        .movie-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Carousel Styles */
        #movieCarousel {
            margin: 0;
            padding: 0;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-bottom: 2rem;
        }

        .carousel-content {
            position: relative;
            height: 70vh;
            min-height: 600px;
            max-height: 800px;
            overflow: hidden;
        }

        .carousel-backdrop {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 20%;
            transform: scale(1);
            transition: transform 6s ease-in-out;
            will-change: transform;
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(90deg, 
                rgba(0, 0, 0, 0.85) 0%,
                rgba(0, 0, 0, 0.6) 50%,
                transparent 100%);
            padding: 60px 10% 60px;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .carousel-caption {
            position: relative;
            right: auto;
            bottom: auto;
            left: auto;
            text-align: left;
            padding: 0;
            max-width: 60%;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: transform, opacity;
        }

        .carousel-caption h2 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .movie-overview {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .carousel-details {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .carousel-details .rating {
            font-size: 1.4rem;
            color: #ffd700;
        }

        .carousel-details .btn {
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
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
            margin-bottom: 0;
        }

        .carousel-indicators button {
            width: 10px;
            height: 10px;
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

        .carousel-item.active .carousel-backdrop {
            transform: scale(1.1);
        }

        .carousel-item.active .carousel-caption {
            opacity: 1;
            transform: translateY(0);
        }

        /* Add a movie info overlay on hover */
        .movie-info-overlay {
            position: absolute;
            bottom: -100%;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            padding: 2rem 1rem 1rem;
            transition: bottom 0.3s ease;
        }

        .content-card:hover .movie-info-overlay {
            bottom: 0;
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
    
    <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
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
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="6000">
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
    
    <div class="container">
        <h1 class="display-4 mb-4">Popular Movies</h1>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('movieCarousel');
        
        function animateSlide(slide) {
            const backdrop = slide.querySelector('.carousel-backdrop');
            const caption = slide.querySelector('.carousel-caption');
            
            if (backdrop && caption) {
                // Reset initial states
                backdrop.style.transition = 'none';
                backdrop.style.transform = 'scale(1)';
                caption.style.transition = 'none';
                caption.style.opacity = '0';
                caption.style.transform = 'translateY(20px)';
                
                // Force reflow
                backdrop.offsetHeight;
                caption.offsetHeight;
                
                // Start animations
                requestAnimationFrame(() => {
                    // Restore transitions
                    backdrop.style.transition = 'transform 6s ease-in-out';
                    caption.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
                    
                    // Apply animations
                    backdrop.style.transform = 'scale(1.1)';
                    caption.style.opacity = '1';
                    caption.style.transform = 'translateY(0)';
                });
            }
        }

        // Initialize first slide immediately after DOM load
        const activeSlide = document.querySelector('.carousel-item.active');
        if (activeSlide) {
            animateSlide(activeSlide);
        }

        // Handle slide changes
        carousel.addEventListener('slide.bs.carousel', function (e) {
            const nextSlide = document.querySelector(`.carousel-item:nth-child(${e.to + 1})`);
            if (nextSlide) {
                const caption = nextSlide.querySelector('.carousel-caption');
                if (caption) {
                    caption.style.opacity = '0';
                    caption.style.transform = 'translateY(20px)';
                }
            }
        });

        carousel.addEventListener('slid.bs.carousel', function () {
            const activeSlide = document.querySelector('.carousel-item.active');
            if (activeSlide) {
                animateSlide(activeSlide);
            }
        });
    });
    </script>
</body>
</html> 