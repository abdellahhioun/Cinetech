<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular TV Shows</title>
    <style>
        nav {
            background-color: #333;
            padding: 1em;
            margin-bottom: 2em;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 1em;
            margin-right: 1em;
        }
        nav a:hover {
            background-color: #555;
        }
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .content-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .content-card h2 {
            margin-top: 0;
            font-size: 1.2em;
        }
        .content-card p {
            font-size: 0.9em;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .content-card a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .content-card a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
        <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
    </nav>
    
    <h1>Popular TV Shows</h1>
    <div class="content-grid">
        <?php foreach ($tvShows['results'] as $show): ?>
            <div class="content-card">
                <h2><?= htmlspecialchars($show['name']) ?></h2>
                <p><?= htmlspecialchars($show['overview']) ?></p>
                <a href="index.php?controller=movie&action=details&id=<?= $show['id'] ?>&type=tv">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html> 