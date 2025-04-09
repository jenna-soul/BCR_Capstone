<?php 
session_start();

include ('../includes/header.php');
require_once('../../mysqli_connect.php');
//check session first
if (!isset($_SESSION['empid'])){
	echo("	<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
				<input type='submit' name='submit' value='Login'/>
			</form>
			<form action='/BCR/htdocs/Home/logincustomer.php'>
				<input type='submit' name='submit' value='Customer Login'/>
			</form>
			<p><br /><br /></p>");
	exit();
}else{
?>
<html>
<head>
    <title>Search Transactions</title>
</head>
<body>
    <!-- Search Form (always visible) -->
    <h1 class='pagetitle'>Search Transactions</h1>
    <form action="" method="post" style="margin-top:1%;">
        <input type="text" name="searchTerm" size="75" placeholder="Search" value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>">
        <input type="submit"  style="margin-left:1%;" value="Search"></input>
    </form>

</body>
</html>
<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchTerm = isset($_POST['searchTerm']) ? mysqli_real_escape_string($dbc, $_POST['searchTerm']) : '';


    $query = "SELECT TransID, 
                     CONCAT(Customers.FirstName, ' ', Customers.LastName) AS CustomerName, 
                     CONCAT(Users.FirstName, ' ', Users.LastName) AS EmployeeName,
                     RentalDate, DueDate, ReturnDate, NumItems, TotalCost
              FROM Transactions
              JOIN Customers ON Transactions.CustID = Customers.CustID
              JOIN Users ON Transactions.EmpID = Users.EmpID
              WHERE 1=1";
    
    if (!empty($searchTerm)) {
        if (is_numeric($searchTerm)) {
            // Searches numeric fields
            $query .= " AND (TransID = '$searchTerm' 
                            OR TotalCost = '$searchTerm' 
                            OR NumItems = '$searchTerm')";
        } elseif (strtotime($searchTerm)) {
            // Searches date fields 
            $query .= " AND (RentalDate LIKE '%$searchTerm%' 
                            OR DueDate LIKE '%$searchTerm%'                            
                            OR ReturnDate LIKE'%$searchTerm%')";
        } else {
            // Searches text fields 
            $query .= " AND (CONCAT(Customers.FirstName, ' ', Customers.LastName) LIKE '%$searchTerm%' 
                            OR CONCAT(Users.FirstName, ' ', Users.LastName) LIKE '%$searchTerm%')";
        }
    }

    // Execute the query
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);
    
    if ($num > 0) { 
        echo "<h2>Your search returned $num entries.</h2>";
        echo "<table id='allTables'><tr>
        <th>Transaction ID</th><th>Customer</th><th>Employee</th><th>Rental Date</th><th>Due Date</th><th>Return Date</th><th>Items</th><th>Total Cost</th><th>View Details</th><th>Update</th>
        </tr>";

        // Fetch and display all records
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $row['TransID'] . "</td>";
            echo "<td>" . $row['CustomerName'] . "</td>";
            echo "<td>" . $row['EmployeeName'] . "</td>";
            echo "<td>" . $row['RentalDate'] . "</td>";
            echo "<td>" . $row['DueDate'] . "</td>";
            echo "<td>" . $row['ReturnDate'] . "</td>";
            echo "<td>" . $row['NumItems'] . "</td>";
            echo "<td>" . $row['TotalCost'] . "</td>";
            echo "<td><a href='details.php?id=" . $row['TransID'] . "'>View Details</a></td>";
            echo "<td><a href='updateform.php?id=" . $row['TransID'] . "'>Update</a></td>";
        }
        echo "</table>";
        echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
    } else {
        echo '<h2>Your search returned no results.</h2>';
        echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
    }
    
    // Close database connection
    mysqli_close($dbc);
}
?>


<?php
include("../includes/footer.php");
}
?>
