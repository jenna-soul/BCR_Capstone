<?php
session_start();
// Include header
include('../includes/header.php');
require_once('../../mysqli_connect.php');
//check session first
if (!isset($_SESSION['empid'])){// Print a customized message.
    echo("<h2>You are not logged in.</h2>
        <form action='login.php''>
            <input type='submit' name='submit' value='Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}else{

// Check if the logged-in user is a manager
$empid = $_SESSION['empid']; // Get the current user's EmpID
$query = "SELECT IsManager FROM Users WHERE EmpID=$empid";
$result = @mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($row['IsManager'] != 1) {
    // If the user is not a manager, deny access
    echo "<h2>You do not have permission to access this page.</h2>";
    include('../includes/footer.php');
    exit();
}

// Check if required GET parameters are set and not empty
if (!isset($_GET['id']) || empty($_GET['id']) || 
    !isset($_GET['fname']) || empty($_GET['fname']) || 
    !isset($_GET['lname']) || empty($_GET['lname'])) {
    echo "<p>Invalid request. Missing user details.</p>";
    include('../includes/footer.php');
    exit();
}

// Sanitize input to prevent SQL injection
$id = intval($_GET['id']); // Ensure it's a number
$fname = htmlspecialchars($_GET['fname']); 
$lname = htmlspecialchars($_GET['lname']);

echo '<style>
.buttons {
	display: flex;
	justify-content: center; 
	gap: 10px; 
	margin-top: 20px; 
}
.buttons form {
	margin: 0;
}
.buttons input {
	padding: 10px 20px;
	font-size: 16px;
	cursor: pointer;
}
    .yesno{
    width:auto;
}
</style>';

// If deletion is confirmed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && $_POST['confirm'] == 'Yes') {
    $query = "DELETE FROM Users WHERE EmpID=$id";
    $result = @mysqli_query($dbc, $query);

    if ($result) {
        echo "<h2>The selected user record has been deleted.</h2>";
    } else {
        echo "<h2>The selected user record could not be deleted.</h2>";
    }
    echo "<p><a href='/BCR/htdocs/employees/index.php'>Back to Employees</a></p>";
} else {
    // Fetch user details for confirmation
    $query = "SELECT * FROM Users WHERE EmpID=$id";
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);

    echo ("<h1 class='pagetitle'>Delete Employee</h1>");
    if ($num > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<h2>Are you sure you want to delete this employee record?</h2>";
        echo "<p><strong>Name: </strong>" . $row['FirstName'] ." ". $row['LastName'] . "</p>";
        echo '<div class="buttons">
			<form method="POST" class="yesno">
                <input type="submit" name="confirm" value="Yes">
              </form>
			  <form action="/BCR/htdocs/employees/index.php" class="yesno">
				  <input type="submit" name="submit" value="No"class="no"/>
			  </form></div>';	  
              echo '<p id="searchUpdate"><a href=index.php>Back to Employees</a></p> ';
    } else {
        echo '<p>Employee not found.</p>';
        echo '<p id="searchUpdate"><a href=index.php>Back to Employees</a></p> ';
    }
}

mysqli_close($dbc);
include('../includes/footer.php');
}
?>
