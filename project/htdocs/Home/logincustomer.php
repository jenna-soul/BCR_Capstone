<?php

if (isset($_POST['submitted'])) {
	require_once ('../../mysqli_connect.php'); 
	$errors = array(); 
	// Check for an email address.
	if (empty($_POST['email'])) {
		$errors[] = 'You did not enter an ID.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	// Check for a password.
	if (empty($_POST['password'])) {
		$errors[] = 'Please enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, $_POST['password']);
	}
	if (empty($errors)) { 
		$query = "SELECT * FROM Customers WHERE Email='$e' AND password='$p'"; 
		$result = @mysqli_query ($dbc, $query); 
		$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
		if ($row) { 
			//Set the session data:
			session_start(); 
			$_SESSION['email'] = $row['Email'];        

			//Update the Audit log
			$query2 ="INSERT INTO Audit(ID,LoginDate) VALUES ('$e',CURRENT_TIMESTAMP) ";
			$result2 = @mysqli_query ($dbc, $query2); 

			header("Location:../Home/index.php");
			
			exit(); 
		} else { // No record returned 
			$errors[] = 'The ID and password entered do not match those on file.'; 
		}
	} 
	mysqli_close($dbc); 
} else { 
	$errors = NULL;
} 

$page_title = 'Customer Login';
include ('../includes/header.php');
if (!empty($errors)) {
	echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) { 
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}
?>
<style>
</style>
<h1 class='pagetitle'>Customer Login</h1>
<form action="logincustomer.php" method="post">
      <div class="formdiv">
		<label for="email">Email:</label>
		<input type="text" id="moveInput" name="email"  autofocus /> 
      </div>
      <div class="formdiv">
		<label for="password">Password:</label>
		<input type="password" id="moveInput" name="password" />
      </div>
	  <input type="submit" name="submit" value="Login" />
<input type="hidden" name="submitted" value="TRUE" />
</form>

<div id='accountLinks'><a href='../Home/forgotcustomer.php'>Forgot Password?</a></div>;

<?php
include ('../includes/footer.php');
?>
