<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
        }

        .navbar {
            background-color: #181818;
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .navbar a:hover {
            background-color: #232323;
        }

        .container {
            padding: 1rem;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e50914;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #f40612;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <a href="index.php?controller=movie&action=showPopularMovies">Movies</a>
                <a href="index.php?controller=movie&action=showPopularTVShows">TV Shows</a>
            </div>
            <div>
                <!-- Profile Icon -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php?controller=movie&action=showProfile" class="btn btn-secondary">Profile</a>
                <?php else: ?>
                    <a href="index.php?controller=movie&action=showLoginForm" class="btn btn-secondary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">User Profile</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Account created on: <?= htmlspecialchars($user['created_at']) ?></p>
            <!-- Display Profile Picture -->
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="img-fluid" style="max-width: 200px; border-radius: 4px;">
            <?php else: ?>
                <p>No profile picture uploaded.</p>
            <?php endif; ?>
            <form action="index.php?controller=movie&action=updateProfilePicture" method="post" enctype="multipart/form-data">
                <label for="profile_picture">Upload Profile Picture:</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                <button type="submit" class="btn btn-primary mt-2">Update Profile Picture</button>
            </form>
        <?php else: ?>
            <p>You need to <a href="index.php?controller=movie&action=showLoginForm">login</a> to view your profile.</p>
        <?php endif; ?>
    </div>


    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 