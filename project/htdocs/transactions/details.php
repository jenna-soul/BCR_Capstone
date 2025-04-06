<?php
session_start();
// Include the header
include ('../includes/header.php');

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
    require_once ('../../mysqli_connect.php');

    // Check if the transaction ID is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $transID = $_GET['id'];
    } else {
        echo "Invalid Transaction ID.";
        exit();
    }

    // Fetch the transaction details
    $query = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                     CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, 
                     t.RentalDate, t.DueDate, t.NumItems, t.TotalCost 
              FROM Transactions t
              JOIN Customers c ON t.CustID = c.CustID
              JOIN Users e ON t.EmpID = e.EmpID
              WHERE t.TransID = $transID";
    $result = @mysqli_query($dbc, $query);
    $transaction = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$transaction) {
        echo "Transaction not found.";
        exit();
    }

    echo '<style>
            .moviesTable{
                width:50% !important;
            }
    </style>';
    // Display the transaction details
    echo "<h1 class='pagetitle'>Transaction Details</h1>";
    if (mysqli_num_rows($result) > 0) {  
        echo "<table id='allTables' class='moviesTable'><tr><th>Customer</th><th>Employee</th><th>Rental Date</th><th>Due Date</th><th>Number of Items</th><th>Total Cost</th></tr>";
        echo "<tr>
        <td>" . $transaction['CustomerName'] . "</td>
        <td>" . $transaction['EmployeeName'] . "</td>
        <td>" . $transaction['RentalDate'] . "</td>
        <td>" . $transaction['DueDate'] . "</td>
        <td>" . $transaction['NumItems'] . "</td>
        <td>$" . $transaction['TotalCost'] . "</td>
        </tr>";
        echo "</table>";
    }
    
    // Fetch the movies checked out in this transaction
    $query2 = "SELECT m.Title, m.Cost
              FROM TransactionMovies tm
              JOIN Movies m ON tm.MovieID = m.MovieID
              WHERE tm.TransID = $transID";
    $result2 = @mysqli_query($dbc, $query2);

    if (mysqli_num_rows($result2) > 0) {
        echo "<h2 class='transTableHeader transTableHeader2'>Movies Checked Out</h2>";
        echo "<table id='allTables' class='moviesTable'><tr><th>Title</th><th>Cost</th></tr>";
        while ($movie = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $movie['Title'] . "</td><td>$" . $movie['Cost'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No movies found for this transaction.</p>";
    }
    echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include ('../includes/footer.php');
?>
