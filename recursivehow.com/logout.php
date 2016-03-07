<?php
// Begin the session
session_start();

// Unset all of the session variables.
session_unset();

// Destroy the session.
session_destroy();
//doesnt work session already quit $message ='You are now logged out. Please come again'; 
header('Location: index.php');
exit;
?>
