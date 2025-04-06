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
    echo ("<h1 class='pagetitle'>Payroll Breakdown</h1>");
   
    // Query to get payroll info by employee then year
    $query = "SELECT 
                u.EmpID,
                CONCAT(u.FirstName, ' ', u.LastName) AS Employee,
                u.Salary AS YearlySalary,
                (u.Salary / 12) AS MonthlySalary,
                u.WorkHours AS WeeklyHours,
                YEAR(t.RentalDate) AS Year
            FROM Users u
            LEFT JOIN Transactions t ON u.EmpID = t.EmpID AND t.RentalDate IS NOT NULL
            LEFT JOIN TransactionMovies tm ON t.TransID = tm.TransID
            GROUP BY Year, u.EmpID
            ORDER BY Year DESC, u.EmpID;
              
        ";
    
    $result = @mysqli_query($dbc, $query);


    // Table header:
    echo "<table id='allTables' style='width:50%;'><tr>
        <th>EmpID</th><th>Employee</th><th>Yearly Salary</th><th>Monthly Salary</th><th>Weekly Salary</th><th>Year</th></tr>"; 

    // Fetch and print all the records
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['EmpID'] . "</td>"; 
        echo "<td>" . $row['Employee'] . "</td>"; 
        echo "<td>" . $row['YearlySalary'] . "</td>"; 
        echo "<td>" . $row['MonthlySalary'] . "</td>"; 
        echo "<td>" . $row['WeeklyHours'] . "</td>"; 
        echo "<td>" . $row['Year'] . "</td>"; 
    }
    echo "</table>";   

    echo("
        <input type='submit' class='printbtn' onclick='window.print()' name='submit' value='Print Report'/>
    ");     
    mysqli_close($dbc); // Close the database connection.

    // Include the footer
    include ('../includes/footer.php');
}
?>
