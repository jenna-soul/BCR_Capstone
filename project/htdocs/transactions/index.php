<?php
session_start();
// Include the header
include ('../includes/header.php');

//check session first
if (!isset($_SESSION['empid'])){// Print a customized message.
    echo("<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
            <input type='submit' name='submit' value='Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}else{
    require_once ('../../mysqli_connect.php');
    echo ("<center>");
    echo ("<h1 class='pagetitle'>Transactions</h1>");
    echo ("<p id='searchUpdate'><a href=add.php id='add'>New Transaction</a> | <a href=searchform.php id='search'>Search Transactions</a></p>");

    // Set the number of records to display per page
    $display = 10;
    $display2 = 10;

    // Pagination for Rented transactions
    if (isset($_GET['p_rented']) && is_numeric($_GET['p_rented'])) {
        $pages_rented = $_GET['p_rented'];
    } else {
        $queryRented = "SELECT COUNT(TransID) FROM Transactions WHERE Status = 'Rented'";
        $resultRented = @mysqli_query($dbc, $queryRented);
        $rowRented = @mysqli_fetch_array($resultRented, MYSQLI_NUM);
        $recordsRented = $rowRented[0];
        $pages_rented = ($recordsRented > $display) ? ceil($recordsRented / $display) : 1;
    }

    // Determine where in the database to start returning results for Rented
    $startRented = (isset($_GET['s_rented']) && is_numeric($_GET['s_rented'])) ? $_GET['s_rented'] : 0;

    // Query for Rented transactions
    $queryRented = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                            CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, 
                            t.RentalDate, t.DueDate, t.NumItems, t.TotalCost
                     FROM Transactions t
                     JOIN Customers c ON t.CustID = c.CustID
                     JOIN Users e ON t.EmpID = e.EmpID
                     WHERE t.Status = 'Rented'
                     LIMIT $startRented, $display";
    $resultRented = @mysqli_query($dbc, $queryRented);


        // Pagination for Returned transactions
        if (isset($_GET['p_returned']) && is_numeric($_GET['p_returned'])) {
            $pages_returned = $_GET['p_returned'];
        } else {
            $queryReturned = "SELECT COUNT(TransID) FROM Transactions WHERE Status = 'Returned'";
            $resultReturned = @mysqli_query($dbc, $queryReturned);
            $rowReturned = @mysqli_fetch_array($resultReturned, MYSQLI_NUM);
            $recordsReturned = $rowReturned[0];
            $pages_returned = ($recordsReturned > $display2) ? ceil($recordsReturned / $display2) : 1;
        }
    // Determine where in the database to start returning results for Returned
    $startReturned = (isset($_GET['s_returned']) && is_numeric($_GET['s_returned'])) ? $_GET['s_returned'] : 0;

    // Query for Returned transactions
    $queryReturned = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                             CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, 
                             t.RentalDate, t.ReturnDate, t.NumItems, t.TotalCost
                      FROM Transactions t
                      JOIN Customers c ON t.CustID = c.CustID
                      JOIN Users e ON t.EmpID = e.EmpID
                      WHERE t.Status = 'Returned'
                      LIMIT $startReturned, $display2";
    $resultReturned = @mysqli_query($dbc, $queryReturned);

    // Add CSS for highlighting overdue transactions in rented transactions only
    echo "<style>
            .highlight {
                background-color: #FFDDC1 !important; /* Light red for overdue transactions */
            }
        </style>";

    // Display Rented transactions table
    echo "<h2 class='transTableHeader'>Rented Transactions</h2>";
    echo "<table id='allTables'><tr>
            <th>Transaction ID</th><th>Customer</th><th>Employee</th><th>Rental Date</th><th>Due Date</th><th>Items</th><th>Total Cost</th><th>View Details</th><th>Return Transaction</th><th>Update Due Date</th>
            </tr>";
    while ($row = mysqli_fetch_array($resultRented, MYSQLI_ASSOC)) {
        // Get the DueDate from the database and convert it to a timestamp
        $dueDate = strtotime($row['DueDate']);
        // Get the current date as a timestamp
        $currentDate = strtotime(date('Y-m-d'));

        // Apply the highlight class if the DueDate is before today's date
        $highlightClass = ($dueDate < $currentDate) ? 'highlight' : '';

        echo "<tr class='$highlightClass'><td>" . $row['TransID'] . "</td>";
        echo "<td>" . $row['CustomerName'] . "</td>";
        echo "<td>" . $row['EmployeeName'] . "</td>";
        echo "<td>" . $row['RentalDate'] . "</td>";
        echo "<td>" . $row['DueDate'] . "</td>";
        echo "<td>" . $row['NumItems'] . "</td>";
        echo "<td>" . $row['TotalCost'] . "</td>";
        echo "<td><a href='details.php?id=" . $row['TransID'] . "'>View Details</a></td>";
        echo "<td><a href='return.php?id=" . $row['TransID'] . "'>Return</a></td>";
        echo "<td><a href='updateform.php?id=" . $row['TransID'] . "'>Update</a></td>";
    }
    echo "</table> <hr>";

   // Pagination (for Rented)
   if ($pages_rented > 1) {
    echo '<br/><table id="paging"><tr>';
    $current_pageRented = ($startRented / $display) + 1;
    if ($current_pageRented != 1) {
        echo '<td><a href="index.php?s_rented=' . ($startRented - $display) . '&p_rented=' . $pages_rented . '"> Previous </a></td>';
    }
    for ($i = 1; $i <= $pages_rented; $i++) {
        echo ($i != $current_pageRented) ? '<td><a href="index.php?s_rented=' . (($display * ($i - 1))) . '&p_rented=' . $pages_rented . '"> ' . $i . ' </a></td>' : '<td>' . $i . '</td>';
    }
    if ($current_pageRented != $pages_rented) {
        echo '<td><a href="index.php?s_rented=' . ($startRented + $display) . '&p_rented=' . $pages_rented . '"> Next </a></td>';
    }
    echo '</tr></table>';
}


    // Display Returned transactions table
    echo "<h2 class='transTableHeader transTableHeader2'>Returned Transactions</h2>";
    echo "<table id='allTables'><tr>
            <th>Transaction ID</th><th>Customer</th><th>Employee</th><th>Rental Date</th><th>Return Date</th><th>Items</th><th>Total Cost</th><th>View Details</th>
            </tr>";
    while ($row2 = mysqli_fetch_array($resultReturned, MYSQLI_ASSOC)) {
        // Returned transactions should not have the highlight class
        echo "<tr><td>" . $row2['TransID'] . "</td>";
        echo "<td>" . $row2['CustomerName'] . "</td>";
        echo "<td>" . $row2['EmployeeName'] . "</td>";
        echo "<td>" . $row2['RentalDate'] . "</td>";
        echo "<td>" . $row2['ReturnDate'] . "</td>";
        echo "<td>" . $row2['NumItems'] . "</td>";
        echo "<td>" . $row2['TotalCost'] . "</td>";
        echo "<td><a href='details.php?id=" . $row2['TransID'] . "'>View Details</a></td>";
    }
    echo "</table>";

    mysqli_close($dbc);


    // Pagination (for Returned)
    if ($pages_returned > 1) {
        echo '<br/><table id="paging"><tr>';
        $current_pageReturned = ($startReturned / $display2) + 1;
        if ($current_pageReturned != 1) {
            echo '<td><a href="index.php?s_returned=' . ($startReturned - $display2) . '&p_returned=' . $pages_returned . '"> Previous </a></td>';
        }
        for ($i = 1; $i <= $pages_returned; $i++) {
            echo ($i != $current_pageReturned) ? '<td><a href="index.php?s_returned=' . (($display2 * ($i - 1))) . '&p_returned=' . $pages_returned . '"> ' . $i . ' </a></td>' : '<td>' . $i . '</td>';
        }
        if ($current_pageReturned != $pages_returned) {
            echo '<td><a href="index.php?s_returned=' . ($startReturned + $display2) . '&p_returned=' . $pages_returned . '"> Next </a></td>';
        }
        echo '</tr></table>';
    }
    include ('../includes/footer.php');
}
?>
