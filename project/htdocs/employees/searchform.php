<?php
session_start();
//check session first
include ('../includes/header.php');
require_once('../../mysqli_connect.php');
if (!isset($_SESSION['empid'])){// Print a customized message.
    echo("<h2>You are not logged in.</h2>
        <form action='login.php''>
            <input type='submit' name='submit' value='Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}else{

// Check if the logged-in user is a manager
$empid = $_SESSION['empid']; // Get the current user's EmpID
$query = "SELECT IsManager FROM Users WHERE EmpID=$empid";
$result = @mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($row['IsManager'] != 1) {
    // If the user is not a manager, deny access
    echo "<h2>You do not have permission to search for employees.</h2>";
    include('../includes/footer.php');
    exit();
}
?>
<html>
<head>
<title>Search Employees</title>
</head>
<body>
    <!-- Search Form (always visible) -->
    <h1 class='pagetitle'>Search Employees</h1>
    <form action="" method="post" style="margin-top:1%;">
        <input type="text" name="searchTerm" size="75" placeholder="Search" value="<?php echo isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ''; ?>">
        <input type="submit"  style="margin-left:1%;" value="Search"></input>
    </form>

</body>
</html>
<?php 
// Check if the search form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $emp_id = mysqli_real_escape_string($dbc, $_SESSION['empid']);
    $searchTerm = isset($_POST['searchTerm']) ? mysqli_real_escape_string($dbc, $_POST['searchTerm']) : '';

    // Build the query based on the search term
    $query = "SELECT EmpID, FirstName, LastName, Phone, Email, City, State, WorkHours, Salary, isManager FROM Users WHERE 1=1";

    // Only add conditions if the search term is not empty
    if (!empty($searchTerm)) {
        // Check if the search term is numeric or a valid date
        if (is_numeric($searchTerm)) {
            // Numeric fields (e.g., EmpID, Phone)
            $query .= " AND (EmpID = '$searchTerm' 
                            OR Phone LIKE '%$searchTerm%')";
        } else {
            // Text fields (e.g., FirstName, LastName, Email, City, State)
            $query .= " AND (FirstName LIKE '%$searchTerm%' 
                            OR LastName LIKE '%$searchTerm%' 
                            OR Email LIKE '%$searchTerm%' 
                            OR City LIKE '%$searchTerm%' 
                            OR State LIKE '%$searchTerm%')";
        }
    }
    
    // Execute the query
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);
    
    if ($num > 0) { // If it ran OK, display the results
        echo "<h2>Your search returned $num entries.</h2>";
        echo "<table cellpadding=5 cellspacing=5 border=1 id='allTables'>";
        echo "<tr>
                <th>EmpID</th><th>FirstName</th><th>LastName</th><th>Phone</th><th>Email</th><th>City</th><th>State</th><th>WorkHours</th><th>Salary</th><th>Manager</th><th>Delete</th><th>Update Record</th>
              </tr>"; 
        // Fetch and display all records
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<tr><td>".$row['EmpID']."</td>";
            echo "<td>".$row['FirstName']."</td>";
            echo "<td>".$row['LastName']."</td>";
            echo "<td>".$row['Phone']."</td>";
            echo "<td>".$row['Email']."</td>";
            echo "<td>".$row['City']."</td>";
            echo "<td>".$row['State']."</td>";
            echo "<td>".$row['WorkHours']."</td>";
            echo "<td>".$row['Salary']."</td>";
            // Check for 'isManager' field and display 'Yes' or 'No'
            echo "<td>".(isset($row['isManager']) && $row['isManager'] == 1 ? 'Yes' : 'No')."</td>"; 
            echo "<td><a href='delete.php?id=" . urlencode($row['EmpID']) . 
            "&fname=" . urlencode($row['FirstName']) . 
            "&lname=" . urlencode($row['LastName']) . "'>Delete</a></td>";
            echo "<td><a href='updateform.php?id=" . $row['EmpID'] . "&fname=" . urlencode($row['FirstName']) . "&lname=" . urlencode($row['LastName']) . "&phone=" . urlencode($row['Phone']) . "&city=" . urlencode($row['City']) . "&state=" . urlencode($row['State']) . "&email=" . urlencode($row['Email']) . "&workhours=" . urlencode($row['WorkHours']) . "&salary=" . urlencode($row['Salary']) . "&ismanager=" . urlencode($row['isManager']) . "'>Update</a></td></tr>";
        }
        echo "</table>";
        echo '<p id="searchUpdate"><a href=index.php>Back to Employees</a></p> ';
    } else {
        echo '<h2>Your search returned no results.</h2>';
        echo '<p id="searchUpdate"><a href=index.php>Back to Employees</a></p> ';
    }
    
    // Close database connection
    mysqli_close($dbc);
}
?>

<?php
include("../includes/footer.php");
}
?>
