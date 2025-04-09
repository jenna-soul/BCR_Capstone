<?php
session_start();

include('../includes/header.php');
require_once('../../mysqli_connect.php');
//check session first
if (!isset($_SESSION['empid'])){
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
// Step 1: Get all transaction IDs for this employee
$getTransIDs = "SELECT TransID FROM Transactions WHERE EmpID=$id";
$transIDsResult = @mysqli_query($dbc, $getTransIDs);

if ($transIDsResult && mysqli_num_rows($transIDsResult) > 0) {
    while ($transRow = mysqli_fetch_assoc($transIDsResult)) {
        $transID = $transRow['TransID'];

        // Step 2: Delete from TransactionMovies
        $deleteTransactionMovies = "DELETE FROM TransactionMovies WHERE TransID=$transID";
        @mysqli_query($dbc, $deleteTransactionMovies); // Optional: check for errors
    }
}

// Step 3: Delete transactions for this employee
$deleteTransactions = "DELETE FROM Transactions WHERE EmpID=$id";
$transactionsResult = @mysqli_query($dbc, $deleteTransactions);

// Step 4: Delete the employee
if ($transactionsResult) {
    $deleteUser = "DELETE FROM Users WHERE EmpID=$id";
    $userResult = @mysqli_query($dbc, $deleteUser);

    if ($userResult) {
        echo "<h2>The selected user record has been deleted.</h2>";
    } else {
        echo "<h2>The selected user record could not be deleted.</h2>";
    }
} else {
    echo "<h2>The employee's transactions could not be deleted. Employee was not removed.</h2>";
}

echo "<p><a href='/BCR/htdocs/employees/index.php'>Back to Employees</a></p>";
} else {
    // Get user details for confirmation
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
