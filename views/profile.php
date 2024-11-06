<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e50914;
            --secondary-color: #564d4d;
            --dark-bg: #141414;
            --card-bg: #181818;
            --text-primary: #ffffff;
            --text-secondary: #b3b3b3;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .profile-header {
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), var(--dark-bg)),
                        url('https://assets.nflxext.com/ffe/siteui/vlv3/9d3533b2-0e2b-40b2-95e0-ecd7979cc88b/a3873901-5b7c-46eb-b9fa-12fea5197bd3/FR-en-20240311-popsignuptwoweeks-perspective_alpha_website_large.jpg');
            background-size: cover;
            background-position: center;
            padding: 6rem 0 3rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            object-fit: cover;
            margin-bottom: 1rem;
            box-shadow: 0 0 20px rgba(229, 9, 20, 0.3);
            background-color: var(--card-bg);
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .primary-btn {
            background: var(--primary-color);
            color: white;
        }

        .secondary-btn {
            background: var(--secondary-color);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .content-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--secondary-color);
            padding-bottom: 1rem;
        }

        .tab-btn {
            padding: 0.5rem 1rem;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn.active {
            color: var(--text-primary);
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }

        .favorite-card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .favorite-poster {
            position: relative;
            aspect-ratio: 2/3;
            overflow: hidden;
        }

        .favorite-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .favorite-card:hover .favorite-poster img {
            transform: scale(1.05);
        }

        .favorite-info {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .favorite-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .favorite-meta {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .favorite-type {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .view-details {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .view-details:hover {
            color: var(--primary-color);
        }

        .no-content-message {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .no-content-message i {
            color: var(--primary-color);
            opacity: 0.5;
        }

        .no-poster {
            width: 100%;
            height: 100%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .no-poster i {
            font-size: 2rem;
            color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .profile-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .favorites-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .profile-picture-preview {
            position: relative;
            display: inline-block;
        }

        .profile-picture-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-picture-upload {
            opacity: 0;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            transition: opacity 0.3s ease;
        }

        .profile-picture-preview:hover .profile-picture-upload {
            opacity: 1;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--primary-color);
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }

        .upload-btn:hover {
            background-color: #f40612;
        }

        .profile-picture-form {
            display: inline-block;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            object-fit: cover;
            background-color: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .profile-picture-upload {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0 0 50% 50%;
        }

        .profile-picture-preview:hover .profile-picture-upload {
            opacity: 1;
        }

        .upload-btn {
            color: white;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: var(--primary-color);
            transition: background-color 0.3s ease;
        }

        .upload-btn:hover {
            background-color: #f40612;
        }

        #profile-preview {
            transition: filter 0.3s ease;
        }

        .profile-picture-preview:hover #profile-preview {
            filter: brightness(0.8);
        }

        .profile-picture-container {
            position: relative;
            display: inline-block;
        }

        .profile-picture-preview {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            object-fit: cover;
            background-color: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-picture-upload {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0 0 50% 50%;
        }

        .profile-picture-preview:hover .profile-picture-upload {
            opacity: 1;
        }

        .upload-btn {
            color: white;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: var(--primary-color);
            transition: background-color 0.3s ease;
            margin: 0 auto;
        }

        .upload-btn:hover {
            background-color: #f40612;
        }

        .disconnect-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid var(--text-primary);
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .disconnect-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .disconnect-btn i {
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .profile-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .disconnect-btn {
                width: 100%;
                max-width: 200px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
        <div class="profile-header">
            <div class="container text-center">
                <form action="index.php?controller=user&action=updateProfilePicture" method="post" enctype="multipart/form-data" class="profile-picture-form">
                    <div class="profile-picture-container">
                        <div class="profile-picture-preview">
                            <?php if (!empty($user['profile_picture'])): ?>
                                <img src="<?= htmlspecialchars($user['profile_picture']) ?>" 
                                     alt="Profile Picture" 
                                     id="profile-preview" 
                                     class="profile-avatar">
                            <?php else: ?>
                                <div class="profile-avatar" id="profile-preview">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            <div class="profile-picture-upload">
                                <label for="profile_picture" class="upload-btn">
                                    <i class="fas fa-camera"></i>
                                    Change Picture
                                </label>
                                <input type="file" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*" 
                                       style="display: none;">
                            </div>
                        </div>
                    </div>
                </form>
                <h1 class="mt-3"><?= htmlspecialchars($user['username']) ?></h1>
                <p class="text-secondary">Member since <?= date('F Y', strtotime($user['created_at'])) ?></p>
                
                <div class="profile-actions mt-3">
                    <a href="index.php?controller=user&action=logout" class="disconnect-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Disconnect
                    </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="content-tabs">
                <button class="tab-btn active" data-tab="movies">Favorite Movies</button>
                <button class="tab-btn" data-tab="tvshows">Favorite TV Shows</button>
            </div>

            <div class="tab-content">
                <!-- Movies Tab -->
                <div class="tab-pane active" id="movies-content">
                    <?php
                    $stmt = $this->db->prepare("
                        SELECT f.* 
                        FROM favorites f
                        INNER JOIN users u ON f.user_id = u.id
                        WHERE u.username = :username AND f.content_type = 'movie'
                        ORDER BY f.created_at DESC
                    ");
                    $stmt->execute([':username' => $_SESSION['user']]);
                    $favoriteMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($favoriteMovies)): ?>
                        <div class="favorites-grid">
                            <?php foreach ($favoriteMovies as $movie): ?>
                                <div class="favorite-card">
                                    <div class="favorite-poster">
                                        <?php if (!empty($movie['poster_path'])): ?>
                                            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']) ?>" 
                                                 alt="<?= htmlspecialchars($movie['title']) ?>"
                                                 loading="lazy">
                                        <?php endif; ?>
                                    </div>
                                    <div class="favorite-info">
                                        <h3 class="favorite-title"><?= htmlspecialchars($movie['title']) ?></h3>
                                        <a href="index.php?controller=movie&action=details&id=<?= $movie['content_id'] ?>&type=movie" 
                                           class="view-details-btn">View Details</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-content-message">
                            <i class="fas fa-film fa-3x mb-3"></i>
                            <h3>No favorite movies yet</h3>
                            <p>Start exploring and add some movies to your favorites!</p>
                            <a href="index.php?controller=movie&action=showPopularMovies" class="action-btn primary-btn mt-3">
                                Browse Movies
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- TV Shows Tab -->
                <div class="tab-pane" id="tvshows-content">
                    <?php
                    $stmt = $this->db->prepare("
                        SELECT f.* 
                        FROM favorites f
                        INNER JOIN users u ON f.user_id = u.id
                        WHERE u.username = :username AND f.content_type = 'tv'
                        ORDER BY f.created_at DESC
                    ");
                    $stmt->execute([':username' => $_SESSION['user']]);
                    $favoriteTVShows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($favoriteTVShows)): ?>
                        <div class="favorites-grid">
                            <?php foreach ($favoriteTVShows as $show): ?>
                                <div class="favorite-card">
                                    <div class="favorite-poster">
                                        <?php if (!empty($show['poster_path'])): ?>
                                            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($show['poster_path']) ?>" 
                                                 alt="<?= htmlspecialchars($show['title']) ?>"
                                                 loading="lazy">
                                        <?php endif; ?>
                                    </div>
                                    <div class="favorite-info">
                                        <h3 class="favorite-title"><?= htmlspecialchars($show['title']) ?></h3>
                                        <a href="index.php?controller=movie&action=details&id=<?= $show['content_id'] ?>&type=tv" 
                                           class="view-details-btn">View Details</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-content-message">
                            <i class="fas fa-tv fa-3x mb-3"></i>
                            <h3>No favorite TV shows yet</h3>
                            <p>Start exploring and add some TV shows to your favorites!</p>
                            <a href="index.php?controller=movie&action=showPopularTVShows" class="action-btn primary-btn mt-3">
                                Browse TV Shows
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container text-center py-5">
            <h2>Please login to view your profile</h2>
            <a href="index.php?controller=user&action=showLoginForm" class="action-btn primary-btn mt-3">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileInput = document.getElementById('profile_picture');
        const profilePreview = document.getElementById('profile-preview');
        const form = document.querySelector('.profile-picture-form');

        profileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (profilePreview.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.id = 'profile-preview';
                        img.className = 'profile-avatar';
                        img.alt = 'Profile Picture';
                        profilePreview.parentNode.replaceChild(img, profilePreview);
                    }
                    document.getElementById('profile-preview').src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
                form.submit();
            }
        });

        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(this.dataset.tab + '-content').classList.add('active');
            });
        });
    });
    </script>
</body>
</html> 