<?php
if (isset($_POST['submitted'])) {
	require_once ('../../mysqli_connect.php'); // Connect to database.
	$errors = array(); 

	// Check for an id.
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
		$result = @mysqli_query ($dbc, $query); 
		$row = mysqli_fetch_array ($result, MYSQLI_NUM);
		if ($row) { 
			//Set the session data:
			session_start(); 
			$_SESSION['empid'] = $row[0];
			$_SESSION['first_name'] = $row[1];
			$_SESSION['last_name'] = $row[2];
			$_SESSION['Email'] = $row[3]; 

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

<h1 class='pagetitle'>Employee Login</h1>
<form action="login.php" method="post">
      <div class="formdiv">
		<label for="empid">Employee ID:</label>
		<input type="text" name="empid"  autofocus/> 
      </div>
      <div class="formdiv">
		<label for="password">Password:</label>
		<input type="password" id="moveInput" name="password" />
      </div>
	  <input type="submit" name="submit" value="Login" />
<input type="hidden" name="submitted" value="TRUE" />
</form>

<div id='accountLinks'><a href='../Home/forgot.php'>Forgot Password?</a></div>;

<?php
include ('../includes/footer.php');
?>
