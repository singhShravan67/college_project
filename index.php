<?php
require_once 'AuthController.php';
require_once 'EventController.php';

// Initialize controller
$authController = new AuthController();
$eventController = new EventController();

// Handle logout
$authController->logout();

// Handle authentication
$login_error = $authController->handleLogin();
$register_result = $authController->handleRegister();
$register_error = null;
$register_success = null;

if ($register_result) {
    if ($register_result['success']) {
        $register_success = $register_result['message'];
    } else {
        $register_error = $register_result['message'];
    }
}

// Handle event registration
$event_register_result = $eventController->handleEventRegistration($authController->getCurrentUserId());
$event_register_error = null;
$event_register_success = null;

if ($event_register_result) {
    if ($event_register_result['success']) {
        $event_register_success = $event_register_result['message'];
    } else {
        $event_register_error = $event_register_result['message'];
    }
}

// Get search and filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Get data
$result = $eventController->getEvents($search, $category_filter, $status_filter);
$categories = $eventController->getCategories();
$stats = $eventController->getStats();
$user_registrations = $eventController->getUserRegistrations($authController->getCurrentUserId());

// Include the view
include 'index_view.php';
?>