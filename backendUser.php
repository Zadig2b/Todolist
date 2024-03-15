<?php
session_start();

// Check if the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    // Retrieve the user ID from the session
    $userId = $_SESSION['user_id'];

    // Return the user ID as JSON data
    echo json_encode(['userId' => $userId]);
} else {
    // If the user ID is not set in the session, return an error
    echo json_encode(['error' => 'User ID not found in session']);
}
?>
