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
            margin: 0;
            padding: 0;
        }

        .movie-hero {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 50px 0;
            margin-bottom: 0;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(5px) brightness(0.3);
        }

        .movie-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        @media (max-width: 768px) {
            .movie-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .movie-poster {
                width: 200px !important;
            }

            .movie-meta {
                justify-content: center;
            }
        }

        .movie-poster {
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }

        .movie-poster:hover {
            transform: scale(1.02);
        }

        .movie-info {
            flex: 1;
        }

        .movie-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .movie-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            color: #cccccc;
        }

        .rating {
            color: var(--secondary-color);
            font-weight: bold;
        }

        .overview {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .cast-section {
            padding: 3rem;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            margin: 2rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .cast-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .cast-item {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .cast-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .cast-image {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--secondary-color);
            transition: transform 0.3s ease;
        }

        .cast-item:hover .cast-image {
            transform: scale(1.05);
        }

        .cast-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0.5rem 0;
            color: #ffffff;
        }

        .cast-character {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin: 0;
        }

        .trailer-section {
            margin-top: 2rem;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .trailer-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }

        .trailer-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .similar-movies {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 4rem 0;
            margin-top: 2rem;
        }

        .similar-movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
        }

        .similar-movie-card {
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .similar-movie-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .similar-movie-poster {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .similar-movie-card:hover .similar-movie-poster {
            transform: scale(1.05);
        }

        .similar-movie-info {
            padding: 1.2rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
        }

        .similar-movie-title {
            font-size: 1.1rem;
            margin-bottom: 0.8rem;
            color: #ffffff;
            font-weight: 500;
        }

        .similar-movie-rating {
            color: var(--secondary-color);
            font-size: 1rem;
            font-weight: bold;
            display: inline-block;
            padding: 0.2rem 0.5rem;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        .placeholder-image {
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .placeholder-image:hover {
            transform: scale(1.05);
        }

        .placeholder-image span {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="movie-hero">
        <div class="hero-background" style="background-image: url('https://image.tmdb.org/t/p/original<?php echo htmlspecialchars($details['backdrop_path']); ?>')"></div>
        
        <div class="movie-content">
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['poster_path']); ?>" 
                 alt="<?php echo htmlspecialchars($details['name']); ?>" 
                 class="movie-poster">
            
            <div class="movie-info">
                <h1 class="movie-title"><?php echo htmlspecialchars($details['name']); ?></h1>
                
                <div class="movie-meta">
                    <span><?php echo htmlspecialchars($details['first_air_date']); ?></span>
                    <span>•</span>
                    <span class="rating"><?php echo number_format($details['vote_average'], 1); ?>/10</span>
                </div>
                
                <div class="overview">
                    <?php echo htmlspecialchars($details['overview']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($details['videos']['results'])): ?>
        <div class="trailer-section">
            <h2>Trailer</h2>
            <div class="trailer-container">
                <?php
                $trailer = $details['videos']['results'][0] ?? null;
                if ($trailer && $trailer['site'] === 'YouTube'): 
                ?>
                    <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($trailer['key']); ?>" 
                            frameborder="0" 
                            allowfullscreen>
                    </iframe>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($details['credits']['cast'])): ?>
        <div class="cast-section">
            <h2>Cast</h2>
            <div class="cast-list">
                <?php 
                $mainCast = array_slice($details['credits']['cast'], 0, 6);
                foreach ($mainCast as $actor): 
                ?>
                    <a href="index.php?controller=movie&action=details&id=<?= $actor['id'] ?>&type=person" 
                       class="cast-item text-decoration-none">
                        <?php if (!empty($actor['profile_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w185<?php echo htmlspecialchars($actor['profile_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($actor['name']); ?>"
                                 class="cast-image">
                        <?php else: ?>
                            <div class="cast-image placeholder-image">
                                <span><?php echo substr($actor['name'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <h3 class="cast-name"><?php echo htmlspecialchars($actor['name']); ?></h3>
                        <p class="cast-character"><?php echo htmlspecialchars($actor['character']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($details['similar']['results'])): ?>
        <div class="similar-movies">
            <h2 class="mb-4">Similar TV Shows You Might Like</h2>
            <div class="similar-movies-grid">
                <?php foreach (array_slice($details['similar']['results'], 0, 6) as $similar): ?>
                    <a href="index.php?controller=movie&action=details&id=<?= $similar['id'] ?>&type=tv" 
                       class="similar-movie-card text-decoration-none">
                        <?php if (!empty($similar['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($similar['poster_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($similar['name']); ?>"
                                 class="similar-movie-poster">
                        <?php endif; ?>
                        <div class="similar-movie-info">
                            <h3 class="similar-movie-title"><?php echo htmlspecialchars($similar['name']); ?></h3>
                            <?php if (!empty($similar['vote_average'])): ?>
                                <span class="similar-movie-rating">
                                    <?php echo number_format($similar['vote_average'], 1); ?>/10
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 