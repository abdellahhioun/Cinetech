<!-- views/detail.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Details</title>
</head>
<body>
    <h1><?= htmlspecialchars($movie['title']) ?></h1>
    <p><strong>Overview:</strong> <?= htmlspecialchars($movie['overview']) ?></p>
    <p><strong>Genres:</strong> <?= implode(', ', array_column($movie['genres'], 'name')) ?></p>
    <p><strong>Release Date:</strong> <?= htmlspecialchars($movie['release_date']) ?></p>
</body>
</html>
