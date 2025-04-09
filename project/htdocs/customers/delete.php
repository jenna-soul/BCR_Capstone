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
// Check if required GET parameters are set and not empty
if (!isset($_GET['id']) || empty($_GET['id']) || 
    !isset($_GET['fname']) || empty($_GET['fname']) || 
    !isset($_GET['lname']) || empty($_GET['lname'])) {
    echo "<p>Invalid request. Missing customer details.</p>";
    include('../includes/footer.php');
    exit();
}
// Sanitize input to prevent SQL injection
$id = intval($_GET['id']); 
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
        // Step 1: Get all transaction IDs for this customer
        $getTransIDs = "SELECT TransID FROM Transactions WHERE CustID=$id";
        $transIDsResult = @mysqli_query($dbc, $getTransIDs);

        if ($transIDsResult && mysqli_num_rows($transIDsResult) > 0) {
            while ($transRow = mysqli_fetch_assoc($transIDsResult)) {
                $transID = $transRow['TransID'];

                // Step 2: Delete from TransactionMovies for each TransID
                $deleteTransactionMovies = "DELETE FROM TransactionMovies WHERE TransID=$transID";
                @mysqli_query($dbc, $deleteTransactionMovies); // Optional: check for errors
            }
        }

        // Step 3: Delete transactions for this customer
        $deleteTransactions = "DELETE FROM Transactions WHERE CustID=$id";
        $transactionsResult = @mysqli_query($dbc, $deleteTransactions);

        // Step 4: Delete the customer
        if ($transactionsResult) {
            $deleteCustomer = "DELETE FROM Customers WHERE CustID=$id";
            $customerResult = @mysqli_query($dbc, $deleteCustomer);

            if ($customerResult) {
                echo "<h2>The customer and all their related records were deleted successfully.</h2>";
            } else {
                echo "<h2>The customer could not be deleted.</h2>";
            }
        } else {
            echo "<h2>Could not delete transactions. Customer was not removed.</h2>";
        }

        echo "<p><a href='/BCR/htdocs/customers/index.php'>Back to Customers</a></p>";
} else {
    // Get customer details for confirmation
    $query = "SELECT * FROM Customers WHERE CustID=$id";
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);

    
    echo ("<h1 class='pagetitle'>Delete Customer</h1>");
    if ($num > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<h2>Are you sure you want to delete this customer record?</h2>";
        echo "<p><strong>Name: </strong>" . $row['FirstName'] ." ". $row['LastName'] . "</p>";
        echo '<div class="buttons">
			<form method="POST" class="yesno">
                <input type="submit" name="confirm" value="Yes">
              </form>
			  <form action="/BCR/htdocs/customers/index.php" class="yesno">
				  <input type="submit" name="submit" value="No"class="no"/>
			  </form></div>';	  
              echo '<p id="searchUpdate"><a href=index.php>Back to Customers</a></p> ';	  
    } else {
        echo '<p>Customer not found.</p>';
        echo '<p id="searchUpdate"><a href=index.php>Back to Customers</a></p> ';	  
    }
}

mysqli_close($dbc);
include('../includes/footer.php');
}
?>
