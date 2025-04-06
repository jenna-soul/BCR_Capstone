<?php 

// This page lets the user logout.
session_start(); 

// If no session variable exists, redirect the user.
if (!isset($_SESSION['empid'])) {
	header("Location: index.php");
	exit(); // Quit the script.
} else { // Cancel the session.
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
}

// Include the header code.
include ('../includes/header.php');


echo("<h2>You are not logged in.</h2>
<form action='login.php''>
	<input type='submit' name='submit' value='Login'/>
</form>
<p><br /><br /></p>");
include ('../includes/footer.php');
?>
