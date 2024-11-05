<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($details['title']); ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="movie-details">
        <h1><?php echo htmlspecialchars($details['title']); ?></h1>
        
        <?php if (!empty($details['poster_path'])): ?>
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['poster_path']); ?>" 
                 alt="<?php echo htmlspecialchars($details['title']); ?> Poster">
        <?php endif; ?>

        <div class="overview">
            <h2>Overview</h2>
            <p><?php echo htmlspecialchars($details['overview']); ?></p>
        </div>

        <div class="info">
            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($details['release_date']); ?></p>
            <p><strong>Rating:</strong> <?php echo htmlspecialchars($details['vote_average']); ?>/10</p>
        </div>

        <?php if (!empty($details['credits']['cast'])): ?>
        <div class="cast">
            <h2>Cast</h2>
            <ul>
                <?php foreach (array_slice($details['credits']['cast'], 0, 5) as $actor): ?>
                    <li><?php echo htmlspecialchars($actor['name']); ?> as <?php echo htmlspecialchars($actor['character']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    
    <a href="/">Back to Home</a>
</body>
</html> 