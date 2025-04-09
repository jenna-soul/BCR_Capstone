<?php
session_start();
include ('../includes/header.php');

if (!isset($_SESSION['empid']) && !isset($_SESSION['email'])){
	echo("	<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
				<input type='submit' name='submit' value='Login'/>
			</form>
			<form action='logincustomer.php'>
				<input type='submit' name='submit' value='Customer Login'/>
			</form>
			<p><br /><br /></p>");
	exit();
}

elseif(isset($_SESSION['email'])){
    require_once ('../../mysqli_connect.php');
    $email=$_SESSION['email'];
    

    echo ("<center>");
    echo ("<h1 class='pagetitle'>My Rentals</h1>");

    // Set the number of records to display per page
    $display = 10;
    $display2 = 10;

    // Pagination for Rented transactions
    if (isset($_GET['p_rented']) && is_numeric($_GET['p_rented'])) {
        $pages_rented = $_GET['p_rented'];
    } else {
        $queryRented = "SELECT COUNT(TransID) FROM Transactions t
                     JOIN Customers c ON t.CustID = c.CustID
                     WHERE t.Status = 'Rented'AND c.Email='$email'";
        $resultRented = @mysqli_query($dbc, $queryRented);
        $rowRented = @mysqli_fetch_array($resultRented, MYSQLI_NUM);
        $recordsRented = $rowRented[0];
        $pages_rented = ($recordsRented > $display) ? ceil($recordsRented / $display) : 1;
    }

    $startRented = (isset($_GET['s_rented']) && is_numeric($_GET['s_rented'])) ? $_GET['s_rented'] : 0;

    // Rented transactions
    $queryRented = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                            t.RentalDate, t.DueDate, t.NumItems, t.TotalCost
                     FROM Transactions t
                     JOIN Customers c ON t.CustID = c.CustID
                     JOIN Users e ON t.EmpID = e.EmpID
                     WHERE t.Status = 'Rented'
                     AND c.Email='$email'
                     LIMIT $startRented, $display";
    $resultRented = @mysqli_query($dbc, $queryRented);


        // Pagination for Returned transactions
        if (isset($_GET['p_returned']) && is_numeric($_GET['p_returned'])) {
            $pages_returned = $_GET['p_returned'];
        } else {
            $queryReturned = "SELECT COUNT(TransID) FROM Transactions t
                     JOIN Customers c ON t.CustID = c.CustID
                     WHERE t.Status = 'Returned' AND c.Email='$email'";
            $resultReturned = @mysqli_query($dbc, $queryReturned);
            $rowReturned = @mysqli_fetch_array($resultReturned, MYSQLI_NUM);
            $recordsReturned = $rowReturned[0];
            $pages_returned = ($recordsReturned > $display2) ? ceil($recordsReturned / $display2) : 1;
        }

    $startReturned = (isset($_GET['s_returned']) && is_numeric($_GET['s_returned'])) ? $_GET['s_returned'] : 0;

    // Returned transactions
    $queryReturned = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                             t.RentalDate, t.ReturnDate, t.NumItems, t.TotalCost
                            FROM Transactions t
                            JOIN Customers c ON t.CustID = c.CustID
                            JOIN Users e ON t.EmpID = e.EmpID
                            WHERE t.Status = 'Returned'
                            AND c.Email='$email'
                            LIMIT $startRented, $display";
    $resultReturned = @mysqli_query($dbc, $queryReturned);

    // Highlight overdue transactions
    echo "<style>
            .highlight {
                background-color: #FFDDC1 !important; /* Light red for overdue transactions */
            }
        </style>";

    echo "<h2 class='transTableHeader'>My Current Rentals</h2>";
    echo "<table id='allTables'><tr>
            <th>Customer Name</th><th>Rental Date</th><th>Due Date</th><th>Items</th><th>Total Cost</th><th>View Details</th>
            </tr>";
    while ($row = mysqli_fetch_array($resultRented, MYSQLI_ASSOC)) {
        $dueDate = strtotime($row['DueDate']);
        $currentDate = strtotime(date('Y-m-d'));

        $highlightClass = ($dueDate < $currentDate) ? 'highlight' : '';
        echo "<tr class='$highlightClass'><td>" . $row['CustomerName'] . "</td>";
        echo "<td>" . $row['RentalDate'] . "</td>";
        echo "<td>" . $row['DueDate'] . "</td>";
        echo "<td>" . $row['NumItems'] . "</td>";
        echo "<td>" . $row['TotalCost'] . "</td>";
        echo "<td><a href='details.php?id=" . $row['TransID'] . "'>View Details</a></td></tr>";
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
    echo "<h2 class='transTableHeader transTableHeader2'>My Past Rentals</h2>";
    echo "<table id='allTables'><tr>
            <th>Customer Name</th><th>Rental Date</th><th>Return Date</th><th>Items</th><th>Total Cost</th><th>View Details</th>
            </tr>";
    while ($row2 = mysqli_fetch_array($resultReturned, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row2['CustomerName'] . "</td>";
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
