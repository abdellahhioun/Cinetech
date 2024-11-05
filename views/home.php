<!-- views/home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
    <style>
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .movie-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .movie-card h2 {
            margin-top: 0;
            font-size: 1.2em;
        }
        .movie-card p {
            font-size: 0.9em;
            line-height: 1.4;
            /* Limit overview to 3 lines */
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .movie-card a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .movie-card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Popular Movies</h1>
    <div class="movies-grid">
        <?php foreach ($movies['results'] as $movie): ?>
            <div class="movie-card">
                <h2><?= htmlspecialchars($movie['title']) ?></h2>
                <p><?= htmlspecialchars($movie['overview']) ?></p>
                <a href="index.php?controller=movie&action=details&id=<?= $movie['id'] ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
