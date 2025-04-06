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


    // Get the year and month from the form
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : date("Y");
    $selectedMonth = isset($_GET['option']) ? $_GET['option'] : date("F");

    echo ("<center>"); 
    echo ("<h1 class='pagetitle'>Monthly Expenses - {$selectedYear}</h1>");
    
    echo("
            <form method='get'>
            <p>Year : <input type='text' id='year' name='year' placeholder='Year' value='" . (isset($_GET['year']) ? $_GET['year'] : '') . "' />
            <input type='submit' value='Submit'>
            </p>
            </form>
            ");

    // Query to get all expenses for each month
    $query = "SELECT YEAR(m.PurchaseDate) AS Year, 
                        MONTH(m.PurchaseDate) AS Month, 
                        SUM(m.PurchaseCost)+(SELECT SUM((Salary / 12)) AS MonthlySalary FROM Users ) AS TotalExpenses
                        FROM Movies m 
                        WHERE YEAR(m.PurchaseDate) = '$selectedYear'
                        GROUP BY YEAR(m.PurchaseDate), MONTH(m.PurchaseDate) 
                        ORDER BY Year, Month;
                                        
                    ";
    
    $result = @mysqli_query($dbc, $query);

    $query2="SELECT YEAR(m.PurchaseDate) AS Year, 
                    SUM(m.PurchaseCost) +
                    IFNULL((SELECT SUM(Salary) 
                        FROM Users u 
                        WHERE YEAR(u.HireDate) <='$selectedYear'
                    ), 0) AS TotalExpenses
                FROM Movies m
                WHERE YEAR(m.PurchaseDate) ='$selectedYear'
                GROUP BY YEAR(m.PurchaseDate)
                ORDER BY Year;
                ";
    $result2 = @mysqli_query($dbc, $query2);


    // Table header:
    echo "<table id='allTables' style='width:50%;'><tr>
        <th>Year</th><th>Month</th><th>Total Monthly Expenses</th></tr>"; 

    // Fetch and print all the records
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['Year'] . "</td>"; 
        echo "<td>" . $row['Month'] . "</td>"; 
        echo "<td>" . $row['TotalExpenses'] . "</td>"; 
    }
    echo "</table>";   

    // Monthly Revenue
    echo "<table id='allTables' style='width:15%; text-align:center;'><tr>
        <th style='text-align:center;'>Total  {$selectedYear}  Expenses</th></tr>"; 

    // Fetch and print all the records
    while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['TotalExpenses'] . "</td>"; 
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
