<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="nav-logo">MovieDB</a>
            <div class="nav-links">
                <a href="index.php?controller=movie&action=showTopRatedMovies" class="nav-link">Top Rated</a>
                <a href="index.php?controller=movie&action=showUpcomingMovies" class="nav-link">Coming Soon</a>
                <a href="index.php?controller=movie&action=showPopularMovies" class="nav-link">Movies</a>
                <a href="index.php?controller=movie&action=showPopularTVShows" class="nav-link">TV Shows</a>
            </div>
        </div>
        
        <div class="nav-right">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search movies, TV shows...">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <?php if (isset($_SESSION['user'])): ?>
                <a href="index.php?controller=user&action=showProfile" class="profile-btn">
                    <i class="fas fa-user-circle"></i>
                    Profile
                </a>
            <?php else: ?>
                <a href="index.php?controller=user&action=showLoginForm" class="auth-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav> 