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
    echo ("<h1 class='pagetitle'>Employees</h1>");
    echo ("<p id='searchUpdate'><a href=add.php id='add'>Add a record</a> | <a href=searchform.php id='search'>Search records</a></p>"); 

    // Set the number of records to display per page
    $display = 10;

    // Get the number of pages
    if (isset($_GET['p']) && is_numeric($_GET['p'])){
        $pages = $_GET['p'];
    } else {
        $query = "SELECT COUNT(EmpID) FROM Users";
        $result = @mysqli_query($dbc, $query); 
        $row = @mysqli_fetch_array($result, MYSQLI_NUM);
        $records = $row[0]; // Get the number of records

        // Calculate the number of pages ...
        if ($records > $display) { // More than 1 page is needed
            $pages = ceil($records / $display);
        } else {
            $pages = 1;
        }
    }

    // Determine where in the database to start returning results ...
    if (isset($_GET['s']) && is_numeric($_GET['s'])){
        $start = $_GET['s'];
    } else {
        $start = 0;
    }

    // Make the paginated query
    $query = "SELECT * FROM Users LIMIT $start, $display"; 
    $result = @mysqli_query($dbc, $query);

    // Table header:
    echo "<table id='allTables'><tr>
        <th>Employee ID</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Street Address</th><th>City</th><th>State</th><th>Zip Code</th><th>Email</th><th>Salary</th><th>Work Hours</th><th>Is Manager</th><th>Delete Record</th><th>Update Record</th></tr>"; 

    // Fetch and print all the records
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $row['EmpID'] . "</td>"; 
        echo "<td>" . $row['FirstName'] . "</td>"; 
        echo "<td>" . $row['LastName'] . "</td>"; 
        echo "<td>" . $row['Phone'] . "</td>"; 
        echo "<td>" . $row['StreetAdr'] . "</td>"; 
        echo "<td>" . $row['City'] . "</td>"; 
        echo "<td>" . $row['State'] . "</td>"; 
        echo "<td>" . $row['Zip'] . "</td>"; 
        echo "<td>" . $row['Email'] . "</td>"; 
        echo "<td>" . $row['Salary'] . "</td>"; 
        echo "<td>" . $row['WorkHours'] . "</td>"; 
        echo "<td>" . ($row['IsManager'] ? 'Yes' : 'No') . "</td>"; 
        echo "<td><a href='delete.php?id=" . urlencode($row['EmpID']) . 
        "&fname=" . urlencode($row['FirstName']) . 
        "&lname=" . urlencode($row['LastName']) . "'>Delete</a></td>";
        echo "<td><a href='updateform.php?id=" . $row['EmpID'] . "&fname=" . urlencode($row['FirstName']) . "&lname=" . urlencode($row['LastName']) . "&phone=" . urlencode($row['Phone']) . "&street=" . urlencode($row['StreetAdr']) . "&city=" . urlencode($row['City']) . "&state=" . urlencode($row['State']) . "&zip=" . urlencode($row['Zip']) . "&email=" . urlencode($row['Email']) . "&salary=" . urlencode($row['Salary']) . "&workhours=" . urlencode($row['WorkHours']) . "&ismanager=" . urlencode($row['IsManager']) . "'>Update</a></td></tr>";
    }
    echo "</table>";        
    mysqli_close($dbc); // Close the database connection.

    // Make the links to other pages if necessary.
    if ($pages > 1) {
        echo '<br/><table id="paging"><tr>';
        // Determine what page the script is on:
        $current_page = ($start / $display) + 1;
        // If it is not the first page, make a Previous button:
        if ($current_page != 1) {
            echo '<td><a href="index.php?s=' . ($start - $display) . '&p=' . $pages. '"> Previous </a></td>';
        }
        // Make all the numbered pages:
        for ($i = 1; $i <= $pages; $i++) {
            if ($i != $current_page) { // if not the current page, generate links to that page
                echo '<td><a href="index.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '"> ' . $i . ' </a></td>';
            } else { // if current page, print the page number
                echo '<td>' . $i . '</td>';
            }
        }
        // If it is not the last page, make a Next button:
        if ($current_page != $pages) {
            echo '<td><a href="index.php?s=' . ($start + $display) . '&p=' . $pages . '"> Next </a></td>';
        }

        echo '</tr></table>';  // Close the table.
    } // End of pages links

    // Include the footer
    include ('../includes/footer.php');
}
?>
