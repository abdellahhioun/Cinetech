<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($details['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #032541;
            --secondary-color: #21d07a;
            --dark-bg: #1a1a1a;
        }

        body {
            background-color: var(--dark-bg);
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .movie-hero {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 50px 0;
            margin-bottom: 0;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(5px) brightness(0.3);
        }

        .movie-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        @media (max-width: 768px) {
            .movie-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .movie-poster {
                width: 200px !important;
            }

            .movie-meta {
                justify-content: center;
            }
        }

        .movie-poster {
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }

        .movie-poster:hover {
            transform: scale(1.02);
        }

        .movie-info {
            flex: 1;
        }

        .movie-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .movie-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            color: #cccccc;
        }

        .rating {
            color: var(--secondary-color);
            font-weight: bold;
        }

        .overview {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .cast-section {
            padding: 3rem;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            margin: 2rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .cast-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .cast-item {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .cast-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .cast-image {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--secondary-color);
            transition: transform 0.3s ease;
        }

        .cast-item:hover .cast-image {
            transform: scale(1.05);
        }

        .cast-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0.5rem 0;
            color: #ffffff;
        }

        .cast-character {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin: 0;
        }

        .trailer-section {
            margin-top: 2rem;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .trailer-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }

        .trailer-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .similar-movies {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 4rem 0;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
        }

        .similar-movies::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(to right, 
                var(--dark-bg) 0%, 
                transparent 10%, 
                transparent 90%, 
                var(--dark-bg) 100%
            );
            z-index: 2;
            pointer-events: none;
        }

        .similar-movies h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: linear-gradient(45deg, #fff, var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .similar-movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2.5rem;
            padding: 0 2rem;
            position: relative;
        }

        .similar-movie-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            aspect-ratio: 2/3;
        }

        .similar-movie-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .similar-movie-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .similar-movie-card:hover .similar-movie-poster {
            transform: scale(1.1);
        }

        .similar-movie-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem 1.2rem 1.2rem;
            background: linear-gradient(to top, 
                rgba(0,0,0,0.9) 0%,
                rgba(0,0,0,0.7) 60%,
                transparent 100%
            );
            transform: translateY(100%);
            transition: transform 0.5s ease;
        }

        .similar-movie-card:hover .similar-movie-info {
            transform: translateY(0);
        }

        .similar-movie-title {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: #ffffff;
            font-weight: 500;
        }

        .similar-movie-rating {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
            font-size: 1rem;
            font-weight: bold;
            padding: 0.3rem 0.8rem;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .similar-movie-rating::before {
            content: '★';
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .similar-movies-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1.5rem;
            }

            .similar-movie-info {
                transform: translateY(0);
                padding: 1rem;
            }

            .similar-movie-title {
                font-size: 1rem;
            }
        }

        .placeholder-image {
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .placeholder-image:hover {
            transform: scale(1.05);
        }

        .placeholder-image span {
            font-size: 2rem;
            font-weight: 600;
            color: #ffffff;
        }

        .reviews-section {
            margin: 2rem 0;
            max-width: 100%;
        }

        .reviews-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .reviews-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .review-item {
            background-color: var(--background-color-light);
            border-radius: 4px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .review-author {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .review-author strong {
            font-size: 1rem;
            color: var(--secondary-color);
        }

        .review-content {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .review-rating {
            font-size: 0.9rem;
            color: #999;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .review-rating::before {
            content: '★';
            color: var(--secondary-color);
        }

        .read-more {
            color: var(--secondary-color);
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline;
            margin-left: 0.5rem;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .review-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        .comments-section {
            margin: 2rem 0;
            padding: 1.5rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .comment-form-section {
            margin-bottom: 2rem;
        }

        .comment-form textarea {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .comment-form textarea:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--secondary-color);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(33, 208, 122, 0.25);
        }

        .comment-item {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.03);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .comment-author {
            color: var(--secondary-color);
        }

        .comment-date {
            font-size: 0.9rem;
            color: #888;
        }

        .comment-content {
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="movie-hero">
        <div class="hero-background" style="background-image: url('https://image.tmdb.org/t/p/original<?php echo htmlspecialchars($details['backdrop_path']); ?>')"></div>
        
        <div class="movie-content">
            <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($details['poster_path']); ?>" 
                 alt="<?php echo htmlspecialchars($details['name']); ?>" 
                 class="movie-poster">
            
            <div class="movie-info">
                <h1 class="movie-title"><?php echo htmlspecialchars($details['name']); ?></h1>
                
                <div class="movie-meta">
                    <span><?php echo htmlspecialchars($details['first_air_date']); ?></span>
                    <span>•</span>
                    <span class="rating"><?php echo number_format($details['vote_average'], 1); ?>/10</span>
                </div>
                
                <div class="overview">
                    <?php echo htmlspecialchars($details['overview']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($details['videos']['results'])): ?>
        <div class="trailer-section">
            <h2>Trailer</h2>
            <div class="trailer-container">
                <?php
                $trailer = $details['videos']['results'][0] ?? null;
                if ($trailer && $trailer['site'] === 'YouTube'): 
                ?>
                    <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($trailer['key']); ?>" 
                            frameborder="0" 
                            allowfullscreen>
                    </iframe>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($details['credits']['cast'])): ?>
        <div class="cast-section">
            <h2>Cast</h2>
            <div class="cast-list">
                <?php 
                $mainCast = array_slice($details['credits']['cast'], 0, 6);
                foreach ($mainCast as $actor): 
                ?>
                    <a href="index.php?controller=movie&action=details&id=<?= $actor['id'] ?>&type=person" 
                       class="cast-item text-decoration-none">
                        <?php if (!empty($actor['profile_path'])): ?>
                            <img src="https://image.tmdb.org/t/p/w185<?php echo htmlspecialchars($actor['profile_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($actor['name']); ?>"
                                 class="cast-image">
                        <?php else: ?>
                            <div class="cast-image placeholder-image">
                                <span><?php echo substr($actor['name'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <h3 class="cast-name"><?php echo htmlspecialchars($actor['name']); ?></h3>
                        <p class="cast-character"><?php echo htmlspecialchars($actor['character']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($details['similar']['results'])): ?>
        <div class="similar-movies">
            <div class="container">
                <h2>Similar TV Shows</h2>
                <div class="similar-movies-grid">
                    <?php foreach (array_slice($details['similar']['results'], 0, 6) as $similar): ?>
                        <a href="index.php?controller=movie&action=details&id=<?= $similar['id'] ?>&type=tv" 
                           class="similar-movie-card">
                            <?php if (!empty($similar['poster_path'])): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($similar['poster_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($similar['name']); ?>"
                                     class="similar-movie-poster">
                            <?php endif; ?>
                            <div class="similar-movie-info">
                                <h3 class="similar-movie-title"><?php echo htmlspecialchars($similar['name']); ?></h3>
                                <?php if (!empty($similar['vote_average'])): ?>
                                    <span class="similar-movie-rating">
                                        <?php echo number_format($similar['vote_average'], 1); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="reviews-section">
            <h2>User Reviews</h2>
            <?php if (!empty($reviews)): ?>
                <div class="reviews-container">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div class="review-author">
                                <strong><?= htmlspecialchars($review['author']) ?></strong>
                            </div>
                            <div class="review-content">
                                <?php
                                $maxLength = 150;
                                $content = htmlspecialchars($review['content']);
                                if (strlen($content) > $maxLength) {
                                    $truncatedContent = substr($content, 0, $maxLength) . '...';
                                    echo $truncatedContent . ' <a href="#" class="read-more" onclick="toggleReview(this)">Read more</a>';
                                } else {
                                    echo $content;
                                }
                                ?>
                            </div>
                            <div class="review-rating">
                                <em>Rating: <?= htmlspecialchars($review['rating'] ?? 'N/A') ?></em>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No reviews available for this TV show.</p>
            <?php endif; ?>
        </div>

        <div class="comments-section">
            <h2>Comments</h2>
            
            <?php if (isset($_SESSION['user'])): ?>
                <div class="comment-form-section">
                    <form action="index.php?controller=user&action=addComment" method="POST" class="comment-form">
                        <input type="hidden" name="movie_id" value="<?= htmlspecialchars($details['id']) ?>">
                        <input type="hidden" name="content_type" value="tv">
                        <div class="form-group">
                            <textarea name="comment" class="form-control" rows="3" required 
                                      placeholder="Write your comment here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (!empty($comments)): ?>
                <div class="comments-container">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <div class="comment-header">
                                <strong class="comment-author"><?= htmlspecialchars($comment['user_name']) ?></strong>
                                <span class="comment-date"><?= date('M d, Y', strtotime($comment['created_at'])) ?></span>
                            </div>
                            <div class="comment-content">
                                <?= htmlspecialchars($comment['comment']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleReview(link) {
        const reviewContent = link.parentElement;
        const fullContent = <?= json_encode(array_map('htmlspecialchars', array_column($reviews, 'content'))) ?>;
        const index = Array.from(reviewContent.parentElement.parentElement.children).indexOf(reviewContent.parentElement);
        
        if (link.textContent === 'Read more') {
            reviewContent.innerHTML = fullContent[index] + ' <a href="#" class="read-more" onclick="toggleReview(this)">Read less</a>';
        } else {
            const maxLength = 150;
            const truncatedContent = fullContent[index].substring(0, maxLength) + '...';
            reviewContent.innerHTML = truncatedContent + ' <a href="#" class="read-more" onclick="toggleReview(this)">Read more</a>';
        }
    }
    </script>
</body>
</html> 