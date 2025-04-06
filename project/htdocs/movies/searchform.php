<?php 
session_start();
//include the header
include ('../includes/header.php');
require_once('../../mysqli_connect.php');

//check session first
if (!isset($_SESSION['empid'])){
	echo("	<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
				<input type='submit' name='submit' value='Login'/>
			</form>
			<p><br /><br /></p>");
	exit();
}else{
?>
<html>
<head>
    <title>Search Movies</title>
</head>
<body>
    <!-- Search Form (always visible) -->
    <h1 class='pagetitle'>Search Movies</h1>
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
    $query = "SELECT * FROM Movies WHERE 1=1";
    
    // Only add conditions if the search term is not empty
    if (!empty($searchTerm)) {
        // Check if the search term is numeric or a valid date
        if (is_numeric($searchTerm)) {
            // Numeric fields (e.g., release year, length, etc.)
            $query .= " AND (LengthMin = '$searchTerm' 
                            OR ReleaseYear = '$searchTerm')";
        } elseif (strtotime($searchTerm)) {
            // Date fields (e.g., ReturnDate)
            $query .= " AND (ReturnDate LIKE '%$searchTerm%')";
        } else {
            // Text fields (e.g., title, category, genre, etc.)
            $query .= " AND (Title LIKE '%$searchTerm%' 
                            OR Category LIKE '%$searchTerm%' 
                            OR Genre LIKE '%$searchTerm%' 
                            OR LeadActors LIKE '%$searchTerm%' 
                            OR Director LIKE '%$searchTerm%' 
                            OR Status LIKE '%$searchTerm%')";
        }
    }

	
    // Execute the query
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);
    
    if ($num > 0) { // If it ran OK, display the results
    	echo "<h2>Your search returned $num entries.</h2>";
        echo "<table cellpadding=5 cellspacing=5 border=1 id='allTables'>";
        echo "<tr>
                <th>Movie ID</th><th>Title</th><th>Category</th><th>Genre</th><th>Release Year</th><th>Length (Minutes)</th><th>Language</th><th>Lead Actors</th><th>Director</th><th>Status</th><th>Return Date</th><th>Delete Record</th><th>Update Record</th>
              </tr>"; 

        // Fetch and display all records
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<tr><td>".$row['MovieID']."</td>";
            echo "<td>".$row['Title']."</td>";
            echo "<td>".$row['Category']."</td>";
            echo "<td>".$row['Genre']."</td>";
            echo "<td>".$row['ReleaseYear']."</td>";
            echo "<td>".$row['LengthMin']."</td>";
            echo "<td>".$row['Lang']."</td>";
            echo "<td>".$row['LeadActors']."</td>";
            echo "<td>".$row['Director']."</td>";
            echo "<td>".$row['Status']."</td>";
            echo "<td>".$row['ReturnDate']."</td>";
            echo "<td><a href='delete.php?id=".$row['MovieID']."&title=".($row['Title'] ? urlencode($row['Title']) : '')."'>Delete</a></td>";
            echo "<td><a href='updateform.php?id=".$row['MovieID']."&title=".($row['Title'] ? urlencode($row['Title']) : '')."&category=".($row['Category'] ? urlencode($row['Category']) : '')."&genre=".($row['Genre'] ? urlencode($row['Genre']) : '')."&release=".$row['ReleaseYear']."&length=".$row['LengthMin']."&lang=".($row['Lang'] ? urlencode($row['Lang']) : '')."&actors=".($row['LeadActors'] ? urlencode($row['LeadActors']) : '')."&director=".($row['Director'] ? urlencode($row['Director']) : '')."&status=".($row['Status'] ? urlencode($row['Status']) : '')."&returndate=".($row['ReturnDate'] ? urlencode($row['ReturnDate']) : '')."'>Update</a></td>";
     }
        echo "</table>";
        echo '<p id="searchUpdate"><a href=index.php>Back to Movies</a></p> ';
    } else {
        echo '<h2>Your search returned no results.</h2>';
        echo '<p id="searchUpdate"><a href=index.php>Back to Movies</a></p> ';
    }
    
    // Close database connection
    mysqli_close($dbc);
}
?>


<?php
include("../includes/footer.php");
}
?>
