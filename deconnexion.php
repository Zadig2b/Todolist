<?php
// Start the session
session_start();

// Reset the session
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to index.php
header("Location: index.php");
exit();
?>
