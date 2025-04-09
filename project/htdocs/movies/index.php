<?php
session_start();

	include ('../includes/header.php');

//check session first
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
	echo ("<center>"); 
	echo ("<h1 class='pagetitle'>Movies</h1>");
	echo ("<p id='searchUpdate'><a href=searchform.php id='search'>Search records</a></p>"); 

	//Set the number of records to display per page
	$display = 25;

	if(isset($_GET['p'])&&is_numeric($_GET['p'])){
		$pages = $_GET['p'];
	}else{
		$query = "SELECT COUNT(MovieID) FROM Movies";
		$result = @mysqli_query ($dbc, $query); 
		$row = @mysqli_fetch_array($result, MYSQLI_NUM);
		$records = $row[0]; //get the number of records

		//Calculate the number of pages
		if($records > $display){
			$pages = ceil($records/$display);
		}else{
			$pages = 1;
		}
	}

	if(isset($_GET['s'])&&is_numeric($_GET['s'])){
		$start = $_GET['s'];
	}else{
		$start = 0;
	}

	//Make the visible query
	$query = "SELECT * FROM Movies LIMIT $start, $display"; 
	$result = @mysqli_query ($dbc, $query);

	//Table header:
	echo "<table id='allTables'><tr>
	<th>Title</th><th>Cost</th><th>Genre</th><th>Release Year</th><th>Length (Minutes)</th><th>Language</th><th>Lead Actors</th><th>Director</th> <th>Status</th> <th>Return Date</th></tr>"; 

	//Fetch and print all the records...
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo "<tr><td>".$row['Title']."</td>"; 		
		echo "<td>".$row['Cost']."</td>"; 
		echo "<td>".$row['Genre']."</td>"; 
		echo "<td>".$row['ReleaseYear']."</td>"; 
		echo "<td>".$row['LengthMin']."</td>"; 
		echo "<td>".$row['Lang']."</td>"; 
		echo "<td>".$row['LeadActors']."</td>"; 
		echo "<td>".$row['Director']."</td>"; 
		echo "<td>".$row['Status']."</td>"; 
		echo "<td>".$row['ReturnDate']."</td>"; 
}

	echo "</table>";         
	mysqli_close($dbc); // Close the database connection.

	//Make the links to other pages if necessary.
	if($pages>1){
		echo '<br/><table id="paging"><tr>';
		
		$current_page = ($start/$display) + 1;

		//If it is not the first page, make a Previous button:
		if($current_page != 1){
			echo '<td><a href="index.php?s='. ($start - $display) . '&p=' . $pages. '"> Previous </a></td>';
		}
		//Make all the numbered pages:
		for($i = 1; $i <= $pages; $i++){
			if($i != $current_page){ // if not the current pages, generates links to that page
				echo '<td><a href="index.php?s='. (($display*($i-1))). '&p=' . $pages .'"> ' . $i . ' </a></td>';
			}else{ // if current page, print the page number
				echo '<td>'. $i. '</td>';
			}
		} 
		//If it is not the last page, make a Next button:
		if($current_page != $pages){
			echo '<td><a href="index.php?s=' .($start + $display). '&p='. $pages. '"> Next </a></td>';
		}
		
		echo '</tr></table>';  
}
}
else{
	require_once ('../../mysqli_connect.php');
	echo ("<center>"); 
	echo ("<h1 class='pagetitle'>Movies</h1>");
	echo ("<p id='searchUpdate'><a href=add.php id='add'>Add a record</a> | <a href=searchform.php id='search'>Search records</a></p>"); 

	//Set the number of records to display per page
	$display = 25;

	if(isset($_GET['p'])&&is_numeric($_GET['p'])){
		$pages = $_GET['p'];
	}else{
		$query = "SELECT COUNT(MovieID) FROM Movies";
		$result = @mysqli_query ($dbc, $query); 
		$row = @mysqli_fetch_array($result, MYSQLI_NUM);
		$records = $row[0]; //get the number of records
		//Calculate the number of pages
		if($records > $display){//More than 1 page is needed
			$pages = ceil($records/$display);
		}else{
			$pages = 1;
		}
	}

	if(isset($_GET['s'])&&is_numeric($_GET['s'])){
		$start = $_GET['s'];
	}else{
		$start = 0;
	}

	//Make the paginated query;
	$query = "SELECT * FROM Movies LIMIT $start, $display"; 
	$result = @mysqli_query ($dbc, $query);

	//Table header:
	echo "<table id='allTables'><tr>
	<th>Movie ID</th><th>Title</th><th>Category</th><th>Genre</th><th>Release Year</th><th>Length (Minutes)</th><th>Language</th><th>Lead Actors</th><th>Director</th> <th>Status</th> <th>Return Date</th> <th>Delete Record</th> <th>Update Record</th></tr>"; 

	//Fetch and print all the records...
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
	mysqli_close($dbc); // Close the database connection.

	//Make the links to other pages if necessary.
	if($pages>1){
		echo '<br/><table id="paging"><tr>';
		//Determine what page the script is on:
		$current_page = ($start/$display) + 1;
		//If it is not the first page, make a Previous button:
		if($current_page != 1){
			echo '<td><a href="index.php?s='. ($start - $display) . '&p=' . $pages. '"> Previous </a></td>';
		}
		//Make all the numbered pages:
		for($i = 1; $i <= $pages; $i++){
			if($i != $current_page){ // if not the current pages, generates links to that page
				echo '<td><a href="index.php?s='. (($display*($i-1))). '&p=' . $pages .'"> ' . $i . ' </a></td>';
			}else{ // if current page, print the page number
				echo '<td>'. $i. '</td>';
			}
		} 
		
		//If it is not the last page, make a Next button:
		if($current_page != $pages){
			echo '<td><a href="index.php?s=' .($start + $display). '&p='. $pages. '"> Next </a></td>';
		}
		
		echo '</tr></table>';  
	}

	include ('../includes/footer.php');
}
?>



