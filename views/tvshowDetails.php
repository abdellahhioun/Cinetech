<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($details['name']); ?></title>
</head>
<body>
    <div class="tvshow-details">
        <h1><?php echo htmlspecialchars($details['name']); ?></h1>
        
        <?php if (!empty($details['poster_path'])): ?>
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['poster_path']); ?>" 
                 alt="<?php echo htmlspecialchars($details['name']); ?> Poster">
        <?php endif; ?>

        <div class="overview">
            <h2>Overview</h2>
            <p><?php echo htmlspecialchars($details['overview']); ?></p>
        </div>

        <div class="info">
            <p><strong>First Air Date:</strong> <?php echo htmlspecialchars($details['first_air_date']); ?></p>
            <p><strong>Rating:</strong> <?php echo htmlspecialchars($details['vote_average']); ?>/10</p>
            <p><strong>Number of Seasons:</strong> <?php echo htmlspecialchars($details['number_of_seasons']); ?></p>
            <p><strong>Number of Episodes:</strong> <?php echo htmlspecialchars($details['number_of_episodes']); ?></p>
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