<?php 
#code to deal with forgot password
include ('../includes/header.php');

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	require_once ('../../mysqli_connect.php'); // Connect to the db.
	$errors = array(); // Initialize error array.

	// Check for an EmpID.
	if (empty($_POST['empid'])) {
		$errors[] = 'You forgot to enter your employee ID.';
	} else {
		$e = mysqli_real_escape_string($dbc, $_POST['empid']);
	}

	if (empty($errors)) { // If everything's okay.
		// Check for previous registration.
		$query = "SELECT * FROM Users WHERE EmpID='$e'"; 
		$result = mysqli_query ($dbc, $query);
		if (mysqli_num_rows($result)==1) {
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$p=$row['password']; 
				$u=$row['EmpID']; 
			}								
				// Send an email, if desired.
			$to=$e; 
			$subject="Your final project";
			$body="
			Thank you very much for being a member of Recipe Directory!\n\n
			Here is your password information.\n\n
			Password: ".$p."\n\n
			Thanks again!\n\n
			https://jsoldner.soisweb.uwm.edu/PHP_Flex/Final/htdocs/Home/index.php"; 
			$headers="From: Your name <jsoldner@uwm.edu>\n";  // <-- Replace this to your email address!!!
			mail ($to, $subject, $body, $headers); // SEND the message!  

			// Print a message.
			echo '<h2>Thank you!</h2>
			<p>Please, check your email to get your username and password.</p>'; 

			// Include the footer and quit the script (to not show the form).
			include ('../includes/footer.php');
			exit();
		} else { // Not registered.
			echo '<font color=red><h4>Error!</h4>
			<p>The email address is not in our database.</p></font>';
		}

	} else { // Report the errors.
		echo '<font color=red><h4>Error!</h4>
		<p>The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p></font>';
	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.
} // End of the main Submit conditional.

?>

<h2>Forgot email or password?</h2>
<form action="forgot.php" method="post">
	<p>Employee ID: <input type="text" name="empid" size="20" maxlength="40" style="width: 30%;" value="<?php if (isset($_POST['empid'])) echo $_POST['empid']; ?>"  /> </p>
	<input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<p>

<?php
include ('../includes/footer.php');
?>
