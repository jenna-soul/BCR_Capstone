<?php
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	require_once ('../../mysqli_connect.php'); // Connect to database.
	$errors = array(); // Initialize error array.

	// Check for an empid address.
	if (empty($_POST['empid'])) {
		$errors[] = 'You did not enter an ID.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['empid']));
	}
	// Check for a password.
	if (empty($_POST['password'])) {
		$errors[] = 'Please enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, $_POST['password']);
	}
	if (empty($errors)) { 
		$query = "SELECT * FROM Users WHERE EmpID='$e' AND password='$p'"; 
		$result = @mysqli_query ($dbc, $query); // Run the query.
		$row = mysqli_fetch_array ($result, MYSQLI_NUM);
		if ($row) { // Data was pulled from the database.
			//Set the session data:
			session_start(); 
			$_SESSION['empid'] = $row[0];
			$_SESSION['first_name'] = $row[1];
			$_SESSION['last_name'] = $row[2];
			$_SESSION['Email'] = $row[3]; 

			//Update the Audit log
			$query2 ="INSERT INTO Audit(EmpID,LoginDate) VALUES ('$e',CURRENT_TIMESTAMP) ";
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

$page_title = 'Login';
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

<h2>Login</h2>
<form action="login.php" method="post">
<p>Employee ID: <input type="text" name="empid" size="20" maxlength="40" style="width: 30%;" /> </p>
<p>Password: <input type="password" id="moveInput" name="password" size="20" maxlength="20" /></p>
<p><input type="submit" name="submit" value="Login" /></p>
<input type="hidden" name="submitted" value="TRUE" />
</form>

<div id='accountLinks'><a href='../Home/forgot.php'>Forgot Password?</a></div>;

<?php
include ('../includes/footer.php');
?>
