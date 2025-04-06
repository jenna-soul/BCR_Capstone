<?php
session_start();
// Include the header
include ('../includes/header.php');

// Check session first
if (!isset($_SESSION['empid'])){
	echo("	<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
				<input type='submit' name='submit' value='Login'/>
			</form>
			<p><br /><br /></p>");
	exit();
} else {
    // Include the database connection
    require_once ('../../mysqli_connect.php');

    // Check if the movie ID is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $movieID = $_GET['id'];
    } else {
        echo "Invalid Movie ID.";
        exit();
    }

    // Fetch the movie details from the database
    $query = "SELECT * FROM Movies WHERE MovieID = $movieID";
    $result = @mysqli_query($dbc, $query);
    $movie = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$movie) {
        echo "Movie not found.";
        exit();
    }

    echo '<style>
            form{
                margin-top:2%;
                margin-top:2%;
                width:80%;
                margin-left:auto;
                margin-right:auto;
            }
            input[type=text], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            label{
                font-size:20px;
                float:left;
            }

            input#returnDate {
                float: left;
                font-size: 1.2rem;
            }  
    </style>';

    // Check if the form is submitted
    if (isset($_POST['updateMovie'])) {
        // Sanitize the inputs
        $movieID = $_POST['movieID'];
        $title = mysqli_real_escape_string($dbc, $_POST['title']);
        $category = mysqli_real_escape_string($dbc, $_POST['category']);
        $genre = mysqli_real_escape_string($dbc, $_POST['genre']);
        $releaseYear = $_POST['releaseYear'];
        $length = $_POST['length'];
        $lang = mysqli_real_escape_string($dbc, $_POST['lang']);
        $actors = mysqli_real_escape_string($dbc, $_POST['actors']);
        $director = mysqli_real_escape_string($dbc, $_POST['director']);
        // Perform the update query
        $updateQuery = "UPDATE Movies SET 
                            Title = '$title',
                            Category = '$category',
                            Genre = '$genre',
                            ReleaseYear = '$releaseYear',
                            LengthMin = '$length',
                            Lang = '$lang',
                            LeadActors = '$actors',
                            Director = '$director'
                        WHERE MovieID = $movieID";

        $updateResult = @mysqli_query($dbc, $updateQuery);

        if ($updateResult) {
            echo "<h2 style='margin-bottom:1%;'>" .$movie['Title']." has been updated.</h2>"
            ; 
            
        } else {
            echo "<h2>Error updating movie: " . mysqli_error($dbc) . "</h2>";
        }
    } else {
        // Display the movie update form
	    echo ("<h1 class='pagetitle'>Update Movie</h1>");
        echo "<form action='updateform.php?id=$movieID' method='POST'>
                <input type='hidden' name='movieID' value='".$movie['MovieID']."'>
                <label for='title'>Title:</label><br>
                <input type='text' id='title' name='title' value='".$movie['Title']."' required size='50'>

                <label for='category'>Category:</label><br>
                <input type='text' id='category' name='category' value='".$movie['Category']."' required size='50'>

                <label for='genre'>Genre:</label><br>
                <input type='text' id='genre' name='genre' value='".$movie['Genre']."' required size='50'>

                <label for='releaseYear'>Release Year:</label><br>
                <input type='text' id='releaseYear' name='releaseYear' value='".$movie['ReleaseYear']."' required size='50'>

                <label for='length'>Length (Minutes):</label><br>
                <input type='text' id='length' name='length' value='".$movie['LengthMin']."' required size='50'>

                <label for='lang'>Language:</label><br>
                <input type='text' id='lang' name='lang' value='".$movie['Lang']."' required size='50'>

                <label for='actors'>Lead Actors:</label><br>
                <input type='text' id='actors' name='actors' value='".$movie['LeadActors']."' size='50'>

                <label for='director'>Director:</label><br>
                <input type='text' id='director' name='director' value='".$movie['Director']."' required size='50'>

                <br><br><br>
                <input type='submit' name='updateMovie' id='updMovie' value='Update Movie'>
            </form>
                <p id='searchUpdate'><a href=index.php>Back to Movies</a></p>";
    }

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include ('../includes/footer.php');
?>
