<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="#" class="nav-logo">Cenitech</a>
            
            
                    <a href="index.php?controller=movie&action=showPopularMovies" class="dropdown-item">Movies</a>
                    <a href="index.php?controller=movie&action=showPopularTVShows" class="dropdown-item">TV Shows</a>
        
            
        </div>
        
        <div class="nav-center">
            <div class="search-bar">
                <form action="index.php" method="GET">
                    <input type="hidden" name="controller" value="movie">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="query" class="search-input" placeholder="Search movies, TV shows..." required>
                    <button type="submit" class="search-button">
                        <i class="fas fa-search search-icon"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="nav-right">
            <?php if (isset($_SESSION['user'])): ?>
                <button class="favorite-btn" onclick="window.location.href='index.php?controller=movie&action=showFavorites'">
                    <i class="fas fa-heart"></i> Favorites
                </button>
                <button class="profile-btn" onclick="window.location.href='index.php?controller=user&action=showProfile'">
                    <i class="fas fa-user-circle"></i> Profile
                </button>
            <?php else: ?>
                <a href="index.php?controller=user&action=showLoginForm" class="auth-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav> 