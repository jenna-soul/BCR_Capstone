<?php
session_start();
// Include the header
include('../includes/header.php');

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
    // Include the database connection
    require_once('../../mysqli_connect.php');

    // Check if the transaction ID is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $transID = $_GET['id'];
    } else {
        echo "Invalid Transaction ID.";
        exit();
    }

    // Fetch the transaction details from the database
    $query = "SELECT * FROM Transactions WHERE TransID = $transID";
    $result = @mysqli_query($dbc, $query);
    $transaction = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$transaction) {
        echo "Transaction not found.";
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
            input[type=text], select, input[type=date] {
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
    if (isset($_POST['updateTransaction'])) {
        // Sanitize the inputs
        $transID = $_POST['transID'];
        $custID = $_POST['custID'];
        $empID = $_POST['empID'];
        $rentalDate = $_POST['rentalDate'];
        $dueDate = $_POST['dueDate'];

        // Perform the update query for the Transactions table
        $updateQuery = "UPDATE Transactions SET 
                            RentalDate = '$rentalDate',
                            DueDate = '$dueDate'
                        WHERE TransID = $transID";

        $updateResult = @mysqli_query($dbc, $updateQuery);

        if ($updateResult) {
            // Update the ReturnDate for movies related to this transaction
            $movieQuery = "SELECT MovieID FROM TransactionMovies WHERE TransID = $transID";
            $movieResult = @mysqli_query($dbc, $movieQuery);

            if ($movieResult) {
                while ($movie = mysqli_fetch_array($movieResult, MYSQLI_ASSOC)) {
                    // Update the ReturnDate for each movie
                    $movieID = $movie['MovieID'];
                    $updateMovieQuery = "UPDATE Movies SET 
                                            ReturnDate = '$dueDate' 
                                          WHERE MovieID = $movieID";
                    @mysqli_query($dbc, $updateMovieQuery);
                }
            }

            echo "<h2 style='margin-bottom:1%;'>Transaction #$transID has been updated.</h2>"; 
            echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
        } else {
            echo "<h2>Error updating transaction: " . mysqli_error($dbc) . "</h2>";
        }
    } else {
        // Display the transaction update form
        echo "<h1 class='pagetitle'>Update Transaction #$transID</h1>"; 
        echo "<form action='updateform.php?id=$transID' method='POST'>
                <input type='hidden' name='transID' value='".$transaction['TransID']."'>
                
                <label for='custID'>Customer ID:</label><br>
                <input type='text' id='custID' name='custID' value='".$transaction['CustID']."' required size='50'>

                <label for='empID'>Employee ID:</label><br>
                <input type='text' id='empID' name='empID' value='".$transaction['EmpID']."' required size='50'>

                <label for='rentalDate'>Rental Date:</label><br>
                <input type='date' id='rentalDate' name='rentalDate' value='".$transaction['RentalDate']."' required size='50'>

                <label for='dueDate'>Due Date:</label><br>
                <input type='date' id='dueDate' name='dueDate' value='".$transaction['DueDate']."' required size='50'>
                <br><br><br>
                <input type='submit' name='updateTransaction' id='updTransaction' value='Update Due Date'>
            </form>";
            echo '<p id="searchUpdate"><a href=index.php>Back to Transactions</a></p> ';
    }

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include('../includes/footer.php');
?>
