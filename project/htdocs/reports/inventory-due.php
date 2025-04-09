<?php 
session_start();
include ('../includes/header.php');

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
    // Include the database connection
    require_once ('../../mysqli_connect.php');
    
    // Get the logged-in user's EmpID
    $empID = $_SESSION['empid'];
    
    // Query to check if the logged-in user is a manager
    $query = "SELECT IsManager FROM Users WHERE EmpID = $empID";
    $result = @mysqli_query($dbc, $query);
    $user = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$user || $user['IsManager'] != 1) {
        // If the user is not a manager, display an error or redirect
        echo "<h2>You do not have permission to view this page.</h2>";
        exit();
    }
    // Display the page content if the user is a manager

    echo ("<center>"); 
    echo ("<h1 class='pagetitle'>Transactions Past Due Date as of " .date("Y/m/d")."</h1>");

    // Query to get transactions passed the due date
    $query = "SELECT 
                m.MovieID,
                m.Title AS MovieTitle,
                t.TransID,
                c.CustID,
                CONCAT(c.FirstName, ' ', c.LastName) AS Customer,
                c.Phone AS CustomerPhone,
                c.Email AS CustomerEmail,
                t.RentalDate,
                t.DueDate,
                DATEDIFF(CURDATE(), t.DueDate) AS DaysPastDue
            FROM Transactions t
            JOIN TransactionMovies tm ON t.TransID = tm.TransID
            JOIN Movies m ON tm.MovieID = m.MovieID
            JOIN Customers c ON t.CustID = c.CustID
            WHERE t.Status = 'Rented' 
            AND t.DueDate < CURDATE()
            ORDER BY DaysPastDue DESC;";
    
    $result = @mysqli_query($dbc, $query);

    // Table header:
    echo "<table id='allTables' style='width:50%;'><tr>
        <th>Movie ID</th><th>Movie Title</th><th>Transaction ID</th><th>Customer ID</th><th>Customer</th><th>Customer Phone</th><th>Customer Email</th><th>Rental Date</th><th>Due Date</th><th>Days Past Due</th></tr>"; 

    // Get all the records
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['MovieID'] . "</td>"; 
        echo "<td>" . $row['MovieTitle'] . "</td>"; 
        echo "<td>" . $row['TransID'] . "</td>"; 
        echo "<td>" . $row['CustID'] . "</td>"; 
        echo "<td>" . $row['Customer'] . "</td>"; 
        echo "<td>" . $row['CustomerPhone'] . "</td>"; 
        echo "<td>" . $row['CustomerEmail'] . "</td>"; 
        echo "<td>" . $row['RentalDate'] . "</td>"; 
        echo "<td>" . $row['DueDate'] . "</td>"; 
        echo "<td>" . $row['DaysPastDue'] . "</td>"; 
    }

    echo "</table>";  

    echo("
        <input type='submit' class='printbtn' onclick='window.print()' name='submit' value='Print Report'/>
    ");     
    mysqli_close($dbc); // Close the database connection.


    include ('../includes/footer.php');
}
?>
