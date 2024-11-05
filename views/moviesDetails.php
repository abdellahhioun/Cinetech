<!-- views/movieDetails.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movieDetails['title']); ?> - Details</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($movieDetails['title']); ?></h1>
    <p><strong>Overview:</strong> <?php echo htmlspecialchars($movieDetails['overview']); ?></p>
    <p><strong>Release Date:</strong> <?php echo htmlspecialchars($movieDetails['release_date']); ?></p>
    <p><strong>Genres:</strong>
        <?php
        foreach ($movieDetails['genres'] as $genre) {
            echo htmlspecialchars($genre['name']) . ' ';
        }
        ?>
    </p>
    <p><strong>Country of Origin:</strong>
        <?php
        foreach ($movieDetails['production_countries'] as $country) {
            echo htmlspecialchars($country['name']) . ' ';
        }
        ?>
    </p>
    <p><strong>Cast:</strong> [Include cast information here if available in API]</p>
    <a href="javascript:history.back()">Go Back</a>
</body>
</html>
