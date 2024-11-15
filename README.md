# Movie Database Web Application

A dynamic web application that allows users to explore movies, TV shows, and actors using data from The Movie Database (TMDB) API. Built with PHP and modern web technologies.

## 🌟 Features

### Content Exploration
- Browse Now Playing Movies
- Discover Upcoming Releases
- Explore Top Rated Content
- Advanced Search Functionality
- View Actor Profiles and Filmography
- TV Show Information

### User Features
- User Authentication System
- Personalized User Profiles
- Favorite Content Management
- Rating System
- Review and Comment System

### Detailed Information
- Comprehensive Movie/TV Show Details
- Cast and Crew Information
- User Reviews and Ratings
- Similar Content Recommendations
- Trailers and Media Content
- Dynamic Background Images

## 🛠️ Technologies Used

- **Backend**
  - PHP
  - MySQL Database
  - TMDB API Integration

- **Frontend**
  - HTML5
  - CSS3
  - JavaScript
  - Bootstrap 5
  - Font Awesome Icons

- **APIs**
  - The Movie Database (TMDB) API

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- TMDB API key
- Composer (PHP package manager)

## ⚙️ Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/movie-database.git
   cd movie-database
   ```

2. **Configure Environment**
   - Copy `config/config.example.php` to `config/config.php`
   - Update the configuration with your settings:
     ```php
     define('TMDB_API_KEY', 'your_api_key_here');
     define('TMDB_API_BASE_URL', 'https://api.themoviedb.org/3');
     ```

3. **Database Setup**
   - Create a new MySQL database
   - Import the database schema from `database/schema.sql`
   - Update database credentials in configuration file

4. **Web Server Configuration**
   - Configure your web server to point to the project's public directory
   - Ensure proper permissions are set

5. **Install Dependencies**
   ```bash
   composer install
   ```

## 📁 Project Structure

├── config/
│ └── config.php
├── src/
│ ├── Controllers/
│ │ ├── MovieController.php
│ │ └── UserController.php
│ └── assets/
│ ├── styles.css
│ ├── movies.css
│ └── tvshows.css
├── views/
│ ├── movieDetails.php
│ ├── tvshowDetails.php
│ ├── actorDetails.php
│ ├── profile.php
│ └── error.php
├── public/
│ └── css/
└── README.md

## 🎨 Features in Detail

### Movie/TV Show Pages
- Detailed content information
- Dynamic background images
- Cast and crew listings
- Similar content recommendations
- Integrated video trailers
- User reviews and ratings

### User Interface
- Responsive design for all devices
- Modern card-based layout
- Smooth animations and transitions
- Dark theme
- Intuitive navigation
- Search functionality

### Search System
- Real-time search results
- Multiple content type filtering
- Detailed result cards
- Rating and favorite integration

## 🔧 Configuration

### API Configuration
Update your TMDB API key in `config/config.php`:
define('TMDB_API_KEY', '11e5f3e682a7ac70b045778a154ba030');
define('TMDB_API_BASE_URL', 'https://api.themoviedb.org/3');

### Database Configuration
Configure your database connection in the configuration file:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cinetech');
```

## 🙏 Acknowledgments

- [The Movie Database (TMDB)](https://www.themoviedb.org/) for providing the comprehensive API
- [Bootstrap](https://getbootstrap.com/) for the responsive frontend framework
- [Font Awesome](https://fontawesome.com/) for the icon set
- All contributors who have helped to enhance this project

## 📧 Contact

Abd-Ellah HIOUN - [abd-ellah.hioun@laplateforme.io](mailto:abd-ellah.hioun@laplateforme.io)

Project Link: [https://github.com/abdellahhioun/Cinetech](https://github.com/abdellahhioun/Cinetech)


