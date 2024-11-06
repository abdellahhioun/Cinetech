<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($details['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #032541;
            --secondary-color: #21d07a;
            --dark-bg: #1a1a1a;
        }

        body {
            background-color: var(--dark-bg);
            color: #ffffff;
        }

        .actor-profile {
            padding: 4rem 0;
        }

        .actor-image {
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        .actor-info {
            padding: 2rem;
        }

        .filmography {
            margin-top: 3rem;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .movie-card {
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-5px);
        }

        .movie-poster {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
        }

        .movie-info {
            padding: 1rem;
        }

        .movie-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }

        .movie-year {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="actor-profile">
            <div class="row">
                <div class="col-md-4">
                    <?php if (!empty($details['profile_path'])): ?>
                        <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['profile_path']); ?>" 
                             alt="<?php echo htmlspecialchars($details['name']); ?>"
                             class="actor-image">
                    <?php endif; ?>
                </div>
                <div class="col-md-8 actor-info">
                    <h1><?php echo htmlspecialchars($details['name']); ?></h1>
                    <?php if (!empty($details['birthday'])): ?>
                        <p>Born: <?php echo htmlspecialchars($details['birthday']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($details['place_of_birth'])): ?>
                        <p>Place of Birth: <?php echo htmlspecialchars($details['place_of_birth']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($details['biography'])): ?>
                        <h3>Biography</h3>
                        <p><?php echo nl2br(htmlspecialchars($details['biography'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="filmography">
            <h2>Filmography</h2>
            <div class="movie-grid">
                <?php 
                $movies = array_slice($details['movie_credits']['cast'], 0, 12);
                usort($movies, function($a, $b) {
                    return strtotime($b['release_date'] ?? '') - strtotime($a['release_date'] ?? '');
                });
                foreach ($movies as $movie): 
                    if (!empty($movie['poster_path'])):
                ?>
                    <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>&type=movie" 
                       class="movie-card text-decoration-none">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             class="movie-poster">
                        <div class="movie-info">
                            <h3 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h3>
                            <?php if (!empty($movie['release_date'])): ?>
                                <span class="movie-year">
                                    <?php echo date('Y', strtotime($movie['release_date'])); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>