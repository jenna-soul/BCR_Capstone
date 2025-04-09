<?php
session_start();
include('../includes/header.php');
require_once('../../mysqli_connect.php');

// Check session first
if (!isset($_SESSION['empid'])){
	echo("	<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
				<input type='submit' name='submit' value='Login'/>
			</form>
			<p><br /><br /></p>");
	exit();
}else {
    require_once ('../../mysqli_connect.php');

    if (isset($_POST['submit']) && isset($_POST['submitted']) && $_POST['submitted'] == "true") {
        $title = $_POST['title'];
        $valid_categories = ['Current Hit', 'Current Release', 'Popular', 'Regular'];
        $category = in_array($_POST['category'], $valid_categories) ? $_POST['category'] : 'Regular'; // Default if invalid
        $genre = $_POST['genre'];
        $release = $_POST['release'];
        $length = $_POST['length'];
        $lang = $_POST['lang'];
        $actors = $_POST['actors'];
        $director = $_POST['director'];

        // Define the cost based on the selected category
        $costs = [
            'Current Hit' => 2.00,
            'Current Release' => 1.50,
            'Popular' => 1.00,
            'Regular' => 0.50
        ];

        // Get cost for selected category
        $cost = $costs[$category];

        // Insert movie into the database with the correct cost
        $query = "INSERT INTO Movies (Title, Category, Genre, ReleaseYear, LengthMin, Lang, LeadActors, Director, Cost) 
                  VALUES ('$title', '$category', '$genre', '$release', '$length', '$lang', '$actors', '$director', '$cost')";
        
        $result = @mysqli_query($dbc, $query);

        if ($result) {
            echo "<center><h2><b>A new movie has been added.</b></h2>";
            echo "<p><a href=index.php>Show Movies</a></center></h2>";
        } else {
            echo "<p>The record could not be added due to a system error: " . mysqli_error($dbc) . "</p>";
        }
    }

    mysqli_close($dbc);
?>

<style>
    .addmovie form {
        margin-top: 2%;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .addmovie input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .addmovie label {
        font-size: 20px;
        float: left;
    }
</style>

<h1 class='pagetitle'>Add Movie</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="addmovie">
    <label for="title">Title</label>
    <input name="title" type="text" id="title" size="50" class="addmovie" required>

    <label for="category">Category</label>
    <select id="category" name="category" required class="addmovie">
        <option value="Popular">Popular</option>
        <option value="Current Hit">Current Hit</option>
        <option value="Current Release">Current Release</option>
        <option value="Regular">Regular</option>
    </select>

    <label for="genre">Genre</label>
    <input name="genre" type="text" id="genre" size="50" required>

    <label for="release">Release Year</label>
    <input name="release" type="text" id="release" size="50" required>

    <label for="length">Length (Minutes)</label>
    <input name="length" type="text" id="length" size="50" required>

    <label for="lang">Language</label>
    <input name="lang" type="text" id="lang" size="50" required>

    <label for="actors">Lead Actor(s)</label>
    <input name="actors" type="text" id="actors" size="50">

    <label for="director">Director(s)</label>
    <input name="director" type="text" id="director" size="50" required>

    <input type="submit" name="submit" value="Add Movie">
    <input type="reset" value="Reset">
    <input type="hidden" name="submitted" value="true">
</form>
<p id="searchUpdate"><a href=index.php>Back to Movies</a></p>

<?php

include ('../includes/footer.php');
}
?>
