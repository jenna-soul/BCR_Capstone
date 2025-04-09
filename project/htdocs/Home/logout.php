<?php 
session_start(); 

// If no session variable exists, redirect the user.
if (!isset($_SESSION['empid']) && !isset($_SESSION['email'])){
	header("Location: index.php");
	exit(); 
} else { // Cancel the session.
	$_SESSION = array(); 
	session_destroy(); // Destroy the session.
}

include ('../includes/header.php');

echo("<h2>You are not logged in.</h2>
<form action='login.php'>
	<input type='submit' name='submit' value='Employee Login'/>
</form>
<form action='loginCustomer.php'>
	<input type='submit' name='submit' value='Customer Login'/>
</form>
<p><br /><br /></p>");
include ('../includes/footer.php');
?>
