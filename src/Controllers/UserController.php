<?php
namespace App\Controllers;

use Exception;
use PDO;

class UserController {
    private $db;

    public function __construct() {
        // Database connection
        $this->db = new PDO('mysql:host=localhost;dbname=cinetech', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function showLoginForm() {
        require __DIR__ . '/../../views/login.php'; // Load the login view
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username']; // Store user in session
            header('Location: index.php?controller=movie&action=showPopularMovies');
            exit;
        } else {
            $error = 'Invalid username or password';
            require __DIR__ . '/../../views/login.php'; // Reload the login view with error
        }
    }

    public function showRegistrationForm() {
        require __DIR__ . '/../../views/register.php'; // Load the registration view
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $profilePicture = $_FILES['profile_picture'] ?? null;

        if (!empty($username) && !empty($email) && !empty($password)) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Handle file upload
            $profilePicturePath = null;
            if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/';
                $profilePicturePath = 'uploads/' . basename($profilePicture['name']);
                move_uploaded_file($profilePicture['tmp_name'], $uploadDir . basename($profilePicture['name']));
            }

            // Insert user into the database
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (:username, :email, :password, :profile_picture)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':profile_picture', $profilePicturePath);

            try {
                $stmt->execute();
                header('Location: index.php?controller=user&action=showLoginForm');
                exit;
            } catch (Exception $e) {
                $error = 'Username or email already exists';
                require __DIR__ . '/../../views/register.php'; // Reload the registration view with error
            }
        } else {
            $error = 'Please fill in all fields';
            require __DIR__ . '/../../views/register.php'; // Reload the registration view with error
        }
    }

    public function logout() {
        session_destroy(); // Destroy the session
        header('Location: index.php?controller=movie&action=showPopularMovies');
        exit;
    }

    public function showProfile() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        // Fetch user data from the database
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['user']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("User not found");
        }

        require __DIR__ . '/../../views/profile.php'; // Load the profile view
    }

    public function updateProfilePicture() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        $profilePicture = $_FILES['profile_picture'] ?? null;

        if ($profilePicture && $profilePicture['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/';
            $profilePicturePath = 'uploads/' . basename($profilePicture['name']);
            move_uploaded_file($profilePicture['tmp_name'], $uploadDir . basename($profilePicture['name']));

            // Update the user's profile picture in the database
            $stmt = $this->db->prepare("UPDATE users SET profile_picture = :profile_picture WHERE username = :username");
            $stmt->bindParam(':profile_picture', $profilePicturePath);
            $stmt->bindParam(':username', $_SESSION['user']);
            $stmt->execute();
        }

        header('Location: index.php?controller=user&action=showProfile'); // Redirect back to the profile page
        exit;
    }
}
