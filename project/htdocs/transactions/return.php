<?php
session_start();
ob_start(); 
include('../includes/header.php');

//check session first
if (!isset($_SESSION['empid'])){
    echo("<h2>You are not logged in.</h2>
			<form action='/BCR/htdocs/Home/login.php''>
            <input type='submit' name='submit' value='Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}else{
    require_once('../../mysqli_connect.php');

    // Check if the transaction ID is in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $transID = $_GET['id'];
    } else {
        echo "Invalid Transaction ID.";
        exit();
    }

    // Get transaction details
    $query = "SELECT t.TransID, CONCAT(c.FirstName, ' ', c.LastName) AS CustomerName, 
                     CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, 
                     t.RentalDate, t.DueDate, t.NumItems, t.TotalCost 
              FROM Transactions t
              JOIN Customers c ON t.CustID = c.CustID
              JOIN Users e ON t.EmpID = e.EmpID
              WHERE t.TransID = $transID";
    $result = @mysqli_query($dbc, $query);
    $transaction = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$transaction) {
        echo "Transaction not found.";
        exit();
    }

    echo '<style>
            .moviesTable {
                width: 50% !important;
            }
    </style>';

    // Display the transaction details
    echo "<h1 class='pagetitle'>Transaction Details</h1>";
    echo "<p><strong>Customer:</strong> " . $transaction['CustomerName'] . "</p>";
    echo "<p><strong>Employee:</strong> " . $transaction['EmployeeName'] . "</p>";
    echo "<p><strong>Rental Date:</strong> " . $transaction['RentalDate'] . "</p>";
    echo "<p><strong>Due Date:</strong> " . $transaction['DueDate'] . "</p>";
    echo "<p><strong>Number of Items:</strong> " . $transaction['NumItems'] . "</p>";
    echo "<p><strong>Total Cost:</strong> $" . $transaction['TotalCost'] . "</p>";

    // Get the movies checked out in this transaction
    $movieQuery = "SELECT m.Title, m.Cost, m.MovieId
                   FROM TransactionMovies tm
                   JOIN Movies m ON tm.MovieID = m.MovieID
                   WHERE tm.TransID = $transID";
    $movieResult = @mysqli_query($dbc, $movieQuery);

    if (mysqli_num_rows($movieResult) > 0) {
        echo "<h2>Movies Checked Out:</h2>";
        echo "<table id='allTables' class='moviesTable'><tr><th>Title</th><th>Cost</th></tr>";
        while ($movie = mysqli_fetch_array($movieResult, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $movie['Title'] . "</td><td>$" . $movie['Cost'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No movies found for this transaction.</p>";
    }

    // Handle the return transaction functionality
    if (isset($_POST['returnTransaction'])) {
        // Update  the Transactions table - set DueDate to NULL and Status to 'Returned'
        $updateQuery = "UPDATE Transactions SET DueDate = NULL, Status = 'Returned', ReturnDate = CURRENT_TIMESTAMP WHERE TransID = $transID;"; 
        $updateResult = @mysqli_query($dbc, $updateQuery);

        // Get all movie IDs for transaction id
        $movieQuery = "SELECT MovieID FROM TransactionMovies WHERE TransID = $transID";
        $movieResult = @mysqli_query($dbc, $movieQuery);
        while ($movie = mysqli_fetch_array($movieResult, MYSQLI_ASSOC)) {
            $movieID = $movie['MovieID'];
            $updateMovieQuery = "UPDATE Movies SET ReturnDate = NULL, Status='Available' WHERE MovieID = $movieID";
            @mysqli_query($dbc, $updateMovieQuery);
        }
        if ($updateResult) {
            if( $movieQuery){
                echo "<p>Transaction updated successfully.</p>";
                echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
            }
        } else {
            echo "<p>Error updating transaction: " . mysqli_error($dbc) . "</p>";
            echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
        }

    } elseif (isset($_POST['cancel'])) {
        // Redirect to index.php if canceled
        header("Location: index.php");
        exit();  
    } else {
        // Display the confirmation form
        echo "<div class='button-container'>
                <form action='return.php?id=$transID' method='POST'>
                    <input type='submit' name='returnTransaction' class='return-btn' value='Return'>
                </form>
                <form action='return.php?id=$transID' method='POST'>
                    <input type='submit' name='cancel' class='cancel-btn' value='Cancel'>
                </form>
              </div>";
              echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
    }

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include('../includes/footer.php');

// End output buffering and flush the output
ob_end_flush();
?>
