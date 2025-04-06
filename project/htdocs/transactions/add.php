<?php
session_start();
// Include the header
include("../includes/header.php");

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


    require_once('../../mysqli_connect.php');

    // Fetch customers for dropdown
    $custQuery = "SELECT CustID, FirstName, LastName FROM Customers WHERE LateFees <10 ORDER BY LastName, FirstName";
    $custResult = @mysqli_query($dbc, $custQuery);
    
    // Fetch available movies
    $movieQuery = "SELECT MovieID, Title, Lang, Cost FROM Movies WHERE Status='Available' ORDER BY Title";
    $movieResult = @mysqli_query($dbc, $movieQuery);
    
    $transactionPreview = false;
    $transactionCompleted = false;
    
    // Initialize session variables if not set
    $_SESSION['custID'] = $_SESSION['custID'] ?? '';
    $_SESSION['movies'] = $_SESSION['movies'] ?? [];
    $_SESSION['totalCost'] = $_SESSION['totalCost'] ?? 0;
    $_SESSION['moviesList'] = $_SESSION['moviesList'] ?? [];
    $_SESSION['customerName'] = $_SESSION['customerName'] ?? '';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['preview'])) {
    // Store selected values in session for preview
    $_SESSION['custID'] = $_POST['custID'];
    $_SESSION['movies'] = $_POST['movies'] ?? [];
    $_SESSION['payMethod'] = $_POST['payMethod'];  // Capture payment method from the form
    $_SESSION['payDetails'] = $_POST['payDetails'];  // Capture payment details from the form
    $custID = $_SESSION['custID'];
    $movieIDs = $_SESSION['movies'] ?? [];
    $totalCost = 0;
    $moviesList = [];
            
            // Check if customer ID is valid
            if (empty($custID) || !is_numeric($custID)) {
                echo "<p>Please select a valid customer.</p>";
                exit();
            }

            // Fetch customer name
            $custQuery = "SELECT FirstName, LastName FROM Customers WHERE CustID = '$custID'";
            $custResult = @mysqli_query($dbc, $custQuery);
            $custRow = mysqli_fetch_assoc($custResult);
            if (!$custRow) {
                echo "<p>Customer not found.</p>";
                exit();
            }
            $customerName = $custRow['LastName'] . ", " . $custRow['FirstName'];
    
            // Fetch movie details
            if (!empty($movieIDs)) {
                $movieIDsString = implode(",", array_map('intval', $movieIDs));
                $movieQuery = "SELECT MovieID, Title, Lang, Cost FROM Movies WHERE MovieID IN ($movieIDsString)";
                $movieResult = @mysqli_query($dbc, $movieQuery);
    
                while ($row = mysqli_fetch_assoc($movieResult)) {
                    $moviesList[] = $row;
                    $totalCost += $row['Cost'];
                }
            }
    
            $_SESSION['totalCost'] = $totalCost;
            $_SESSION['moviesList'] = $moviesList;
            $_SESSION['customerName'] = $customerName;
            
            $transactionPreview = true;
        } elseif (isset($_POST['confirm'])) {
        // Process the transaction
        $custID = $_SESSION['custID'];
        $movieIDs = $_SESSION['movies'];
        $empID = $_SESSION['empid'];
        $paymentMethod = $_SESSION['payMethod']; 
        $paymentDetails = $_SESSION['payDetails'];
        $rentalDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime('+7 days')); // Assuming a 7-day rental period
        $totalCost = $_SESSION['totalCost'];
        $numItems = count($movieIDs);


        // Check if payment method and details exist in session
        if (empty($_SESSION['payMethod']) || empty($_SESSION['payDetails'])) {
            echo "<p>Please provide payment details.</p>";
            exit();
        }

        $paymentMethod = $_SESSION['payMethod'];
        $paymentDetails = $_SESSION['payDetails'];
            // Check if customer ID is valid
            if (empty($custID) || !is_numeric($custID)) {
                echo "<p>Please select a valid customer.</p>";
                exit();
            }
    
            // Insert transaction
            $transQuery = "INSERT INTO Transactions (CustID, EmpID, RentalDate, DueDate, NumItems, TotalCost, PaymentMethod, PaymentDetails) 
                           VALUES ('$custID', '$empID', '$rentalDate', '$dueDate', '$numItems', '$totalCost','$paymentMethod','$paymentDetails')";
            $transResult = @mysqli_query($dbc, $transQuery);
    
            if ($transResult) {
                $transID = mysqli_insert_id($dbc);
    
                // Insert each selected movie into TransactionMovies and update movie status
                foreach ($movieIDs as $movieID) {
                    // Get movie cost
                    $priceQuery = "SELECT Cost FROM Movies WHERE MovieID = '$movieID'";
                    $priceResult = @mysqli_query($dbc, $priceQuery);
                    $row = mysqli_fetch_assoc($priceResult);
                    $price = $row['Cost'];
    
                    // Insert into TransactionMovies
                    $movieTransQuery = "INSERT INTO TransactionMovies (TransID, MovieID, Price) 
                                        VALUES ('$transID', '$movieID', '$price')";
                    @mysqli_query($dbc, $movieTransQuery);
    
                    // Update Movies table
                    $updateMovieQuery = "UPDATE Movies 
                                         SET Status = 'Rented', ReturnDate = '$dueDate' 
                                         WHERE MovieID = '$movieID'";
                    @mysqli_query($dbc, $updateMovieQuery);
                }
    
                $transactionCompleted = true;
            } else {
                echo "<p>Error creating transaction: " . mysqli_error($dbc) . "</p>";
            }
        }
    }
}
?>

<style>
    .addform form {
        margin-top: 2%;
        margin-left: auto;
        margin-right: auto;
    }
.addform{
        width: 50% !important;

}
    .addform input[type=text], select, .addform input[type=tel], .addform input[type=email] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .addform label {
        font-size: 20px;
        float: left;
    }
    #movies {
    height: 50%;
    font-size: x-large;
    }
    label{
        font-weight:bold;
    }
    /*Preview  styles */
.transdetails{
    margin-top:2%;
    margin-bottom:2%;
    line-height:2rem;
}
.preview {
    border: 2px solid orange;
    width: 50%;
    margin-top:2%;
    margin-bottom:2%;
}
</style>

<h1 class='pagetitle'>Create New Transaction</h1>

<?php if ($transactionCompleted): ?>
    <div class="success">
        <h2>Transaction Completed Successfully!</h2>
        <p><strong>Customer:</strong> <?= $_SESSION['customerName']; ?></p>
        <p><strong>Movies Rented:</strong></p>
        
            <?php foreach ($_SESSION['moviesList'] as $movie): ?>
                <p><?= $movie['Title']; ?> - <?= $movie['Lang']; ?> ($<?= number_format($movie['Cost'], 2); ?>)</p>
            <?php endforeach; ?>
        <p><strong>Payment Method:</strong> <?= $_SESSION['payMethod']; ?></p>
        <p><strong>Payment Details:</strong> <?= $_SESSION['payDetails']; ?></p>
        <p><strong>Total Cost:</strong> $<?= number_format($_SESSION['totalCost'], 2); ?></p>
    </div>

    <p id="searchUpdate"><a href="index.php">Back to Transactions</a></p>

    <?php 
    // Only clear session variables once the success message is shown.
    unset($_SESSION['custID'], $_SESSION['movies'], $_SESSION['totalCost'], $_SESSION['moviesList'], $_SESSION['customerName']);
    ?>


<?php elseif ($transactionPreview): ?>
    <!-- Display transaction preview -->
    <div class="preview">
        <br>
        <h1>Transaction Preview</h1>
        <div class="transdetails">
                <p><strong>Customer:</strong> <?= $_SESSION['customerName']; ?></p>
                <p><strong>Selected Movies:</strong></p>
                    <?php foreach ($_SESSION['moviesList'] as $movie): ?>
                        <p><?= $movie['Title']; ?> - <?= $movie['Lang']; ?> ($<?= number_format($movie['Cost'], 2); ?>)</p>
                    <?php endforeach; ?>

                    <p><strong>Payment Method:</strong> <?= $_SESSION['payMethod']; ?></p>
                    <p><strong>Payment Details:</strong> <?= $_SESSION['payDetails']; ?></p>
                <p><strong>Total Cost:</strong> $<?= number_format($_SESSION['totalCost'], 2); ?></p>
            </div>
        <form action="" method="post">
            <input type="submit" name="confirm" value="Confirm Transaction">
        </form>

        <form action="" method="post">
            <input type="submit" value="Edit Selection">
        </form>
    </div>

    <p id="searchUpdate"><a href="index.php">Back to Transactions</a></p>

<?php else: ?>
    <form action="" method="post" class="addform">
        <label for="custID">Select Customer</label>
        <select name="custID" id="custID" required>
            <option value="">-- Select a Customer --</option>
            <?php while ($row = mysqli_fetch_assoc($custResult)): ?>
                <option value="<?= $row['CustID']; ?>"><?= $row['LastName']; ?>, <?= $row['FirstName']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="movies">Select Movies</label>
        <select name="movies[]" id="movies" multiple required>
            <?php while ($row = mysqli_fetch_assoc($movieResult)): ?>
                <option value="<?= $row['MovieID']; ?>">
                    <?= $row['Title']; ?> - <?= $row['Lang']; ?> ($<?= number_format($row['Cost'], 2); ?>)
                </option>
            <?php endwhile; ?>
        </select>
        <label for="payMethod">Payment Method</label>
        <select name="payMethod" id="payMethod" required>  
            <option value="card">Card</option>
            <option value="cash">Cash</option>
            <option value="check">Check</option>
        </select>
        <label for="payDetails">Payment Details:</label>
        <input type="text" id="payDetails" name="payDetails"><br><br><br><br>               

        <input type="submit" name="preview" value="Preview Transaction">
    </form>
<?php endif; ?>
<?php include("../includes/footer.php"); ?>
