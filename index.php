<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use App\Controllers\MovieController;

$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'showPopularMovies';

switch ($controller) {
    case 'movie':
        $controllerInstance = new MovieController();
        break;
    default:
        die("Controller not found");
}

if (method_exists($controllerInstance, $action)) {
    if (isset($_GET['id'])) {
        $type = $_GET['type'] ?? 'movie';
        $controllerInstance->$action($_GET['id'], $type);
    } else {
        $controllerInstance->$action();
    }
} else {
    die("Action not found");
}
