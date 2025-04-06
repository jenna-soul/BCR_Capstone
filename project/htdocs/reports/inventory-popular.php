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
    echo ("<h1 class='pagetitle'>Most Popular Movies - {$selectedMonth} {$selectedYear}</h1>");
    
    echo("
            <form method='get'>
            <p>Year : <input type='text' id='year' name='year' placeholder='Year' value='" . (isset($_GET['year']) ? $_GET['year'] : '') . "' />
             Month : 
            <select  id='option' name='option'>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'January' ? 'selected' : '') . ">January</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'February' ? 'selected' : '') . ">February</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'March' ? 'selected' : '') . ">March</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'April' ? 'selected' : '') . ">April</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'May' ? 'selected' : '') . ">May</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'June' ? 'selected' : '') . ">June</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'July' ? 'selected' : '') . ">July</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'August' ? 'selected' : '') . ">August</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'September' ? 'selected' : '') . ">September</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'October' ? 'selected' : '') . ">October</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'November' ? 'selected' : '') . ">November</option>
                <option " . (isset($_GET['option']) && $_GET['option'] == 'December' ? 'selected' : '') . ">December</option>
            </select>
            <input type='submit' value='Submit'>
            </p>
            </form>
            ");
    // Convert the month name to a number
    $monthMapping = [
        'January' => 1,
        'February' => 2,
        'March' => 3,
        'April' => 4,
        'May' => 5,
        'June' => 6,
        'July' => 7,
        'August' => 8,
        'September' => 9,
        'October' => 10,
        'November' => 11,
        'December' => 12
    ];
    
    $monthNumber = $monthMapping[$selectedMonth];

    // Query to get employee performance for the selected year and month
    $query = "SELECT 
                m.MovieID,
                m.Title AS MovieTitle,
                COUNT(t.TransID) AS RentalCount,
                MONTH(t.RentalDate) AS Month,
                YEAR(t.RentalDate) AS Year
            FROM Transactions t
            JOIN TransactionMovies tm ON t.TransID = tm.TransID
            JOIN Movies m ON tm.MovieID = m.MovieID
            WHERE MONTH(t.RentalDate) ='$monthNumber'
            AND YEAR(t.RentalDate) = '$selectedYear' 
            GROUP BY m.MovieID, Month, Year
            ORDER BY RentalCount DESC
            LIMIT 50;";
    
    $result = @mysqli_query($dbc, $query);

    // Table header:
    echo "<table id='allTables' style='width:50%;'><tr>
        <th>Movie ID</th><th>Movie Title</th><th>Rental Count</th><th>Month</th><th>Year</th></tr>"; 

    // Fetch and print all the records
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['MovieID'] . "</td>"; 
        echo "<td>" . $row['MovieTitle'] . "</td>"; 
        echo "<td>" . $row['RentalCount'] . "</td>"; 
        echo "<td>" . $row['Month'] . "</td>"; 
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
