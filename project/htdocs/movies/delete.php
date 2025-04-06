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

// Check if both ID and title are provided
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['title']) || empty($_GET['title'])) {
    echo "<p>Invalid request. No movie ID or title provided.</p>";
    include('../includes/footer.php');
    exit();
}

$id = $_GET['id'];
$title = $_GET['title'];
echo '<style>
.buttons {
	display: flex;
	justify-content: center; 
	gap: 10px; 
	margin-top: 20px; 
}
.buttons form {
	margin: 0;
}
.buttons input {
	padding: 10px 20px;
	font-size: 16px;
	cursor: pointer;
}
    .yesno{
    width:auto;
}
</style>';
// If deletion is confirmed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && $_POST['confirm'] == 'Yes') {
    $query = "DELETE FROM Movies WHERE MovieID=$id";
    $result = @mysqli_query($dbc, $query);

    if ($result) {
        echo "<h2>The selected movie has been deleted.</h2>";
    } else {
        echo "<h2>The selected movie could not be deleted.</h2>";
    }
    echo "<p><a href='/BCR/htdocs/movies/index.php'>Back to Movies</a></p>";
} else {
    // Fetch movie details for confirmation
    $query = "SELECT * FROM Movies WHERE MovieID=$id";
    $result = @mysqli_query($dbc, $query);
    $num = mysqli_num_rows($result);

    
    echo ("<h1 class='pagetitle'>Delete Movie</h1>");
    if ($num > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<h2>Are you sure you want to delete this movie?</h2>";
        echo "<p><strong>Title: </strong>" . $row['Title'] . "</p>";
        echo '<div class="buttons">
			<form method="POST" class="yesno">
                <input type="submit" name="confirm" value="Yes">
              </form>
			  <form action="/BCR/htdocs/movies/index.php" class="yesno">
				  <input type="submit" name="submit" value="No"class="no"/>
			  </form></div>';
              
        echo '<p id="searchUpdate"><a href=index.php>Back to Movies</a></p> ';	  
    } else {
        echo '<p>Movie not found.</p>';
    }
}

mysqli_close($dbc);
include('../includes/footer.php');
}
?>
