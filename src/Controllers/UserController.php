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
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Unset all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page or login page
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

        // Store profile picture in session
        $_SESSION['profile_picture'] = $user['profile_picture'];

        require __DIR__ . '/../../views/profile.php';
    }

    public function updateProfilePicture() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=user&action=showLoginForm');
            exit;
        }

        if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
            header('Location: index.php?controller=user&action=showProfile&error=upload');
            exit;
        }

        $file = $_FILES['profile_picture'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            header('Location: index.php?controller=user&action=showProfile&error=type');
            exit;
        }

        // Create uploads directory if it doesn't exist
        $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('profile_') . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        $dbPath = 'uploads/profiles/' . $filename;

        // Delete old profile picture if exists
        $stmt = $this->db->prepare("SELECT profile_picture FROM users WHERE username = :username");
        $stmt->execute([':username' => $_SESSION['user']]);
        $oldPicture = $stmt->fetchColumn();

        if ($oldPicture && file_exists(__DIR__ . '/../../public/' . $oldPicture)) {
            unlink(__DIR__ . '/../../public/' . $oldPicture);
        }

        // Upload new picture
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $stmt = $this->db->prepare("UPDATE users SET profile_picture = :picture WHERE username = :username");
            $stmt->execute([
                ':picture' => $dbPath,
                ':username' => $_SESSION['user']
            ]);
            
            $_SESSION['profile_picture'] = $dbPath;
            header('Location: index.php?controller=user&action=showProfile&success=true');
        } else {
            header('Location: index.php?controller=user&action=showProfile&error=save');
        }
        exit;
    }
}
