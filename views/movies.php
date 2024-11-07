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
    <link rel="stylesheet" href="../src/assets/styles.css">
    <link rel="stylesheet" href="../src/assets/movies.css"> <!-- Link to the new CSS file -->
</head>
<body>
    <?php
    use App\Partials\Navbar;
    use App\Partials\Footer;

    // Create an instance of the Navbar class and render it
    $navbar = new Navbar();
    echo $navbar->render();
    ?>
    
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
    
    <!-- Create an instance of the Footer class and render it -->
    <?php
    $footer = new Footer();
    echo $footer->render();
    ?>
    
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