<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <div class="error-container">
        <h1>Error</h1>
        <p><?php echo htmlspecialchars($error); ?></p>
        <a href="/">Return to Home</a>
    </div>
</body>
</html> 