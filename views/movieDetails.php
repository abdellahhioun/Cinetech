<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($details['title']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
        }
        
        .movie-details {
            background-color: #181818;
            border-radius: 8px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1200px;
        }

        .movie-poster img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        .overview {
            background-color: #232323;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .rating {
            color: #ffd700;
            font-size: 1.2rem;
        }

        .cast-list {
            list-style: none;
            padding: 0;
        }

        .cast-list li {
            background-color: #232323;
            padding: 0.8rem;
            margin: 0.5rem 0;
            border-radius: 4px;
        }

        .back-button {
            background-color: #e50914;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        .back-button:hover {
            background-color: #f40612;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="movie-details">
            <div class="row">
                <div class="col-md-4">
                    <div class="movie-poster">
                        <?php if (!empty($details['poster_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['poster_path']); ?>" 
                                 class="img-fluid" 
                                 alt="<?php echo htmlspecialchars($details['title']); ?> Poster">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <h1 class="display-4 mb-3"><?php echo htmlspecialchars($details['title']); ?></h1>
                    
                    <div class="overview">
                        <h2 class="h4">Overview</h2>
                        <p class="lead"><?php echo htmlspecialchars($details['overview']); ?></p>
                    </div>

                    <div class="info">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Release Date:</strong> <?php echo htmlspecialchars($details['release_date']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Rating:</strong> 
                                    <span class="rating"><?php echo htmlspecialchars($details['vote_average']); ?>/10</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($details['credits']['cast'])): ?>
                    <div class="cast mt-4">
                        <h2 class="h4 mb-3">Cast</h2>
                        <ul class="cast-list">
                            <?php foreach (array_slice($details['credits']['cast'], 0, 5) as $actor): ?>
                                <li><?php echo htmlspecialchars($actor['name']); ?> 
                                    <span class="text-muted">as</span> 
                                    <?php echo htmlspecialchars($actor['character']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <a href="/" class="back-button">Back to Home</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 