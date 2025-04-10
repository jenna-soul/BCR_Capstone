<?php
session_start();
include ('../includes/header.php');


echo '<script src="https://kit.fontawesome.com/636a12d49d.js" crossorigin="anonymous"></script>';
    
echo '<style>
.button {
    background-color: #6699CC; /* Blue */
    border: none;
    color: white;
    padding: 50px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    font-size: 24px;
}
.button:hover {
    background-color:#FF9900 /* Orange */
}
.dashboard{
    margin-top:1%;
}
</style>';


//check session first
if (!isset($_SESSION['empid']) && !isset($_SESSION['email'])){
    echo("<h2>You are not logged in.</h2>    
    <p>To access Brew City Rentals' website, please visit our store and set up a user account.</p><br>
        <form action='login.php'>
            <input type='submit' name='submit' value='Employee Login'/>
        </form>
        <form action='logincustomer.php'>
            <input type='submit' name='submit' value='Customer Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}
elseif(isset($_SESSION['email'])){
    
    echo ('<div class="dashboard">
    <a href="/BCR/htdocs/transactions/customers.php" class="button btn_newTrans"><i class="fa-solid fa-cash-register fa-xl"></i><br><br>My Transactions</a>
    <a href="/BCR/htdocs/movies/index.php" class="button btn_newTrans"><i class="fa-solid fa-compact-disc fa-xl"></i><br><br>Movies</a>
    </div>');
}

elseif(isset($_SESSION['empid'])){
    
    // Include the database connection
    require_once ('../../mysqli_connect.php');
    
    // Get the logged-in user's ID
    $empID = $_SESSION['empid'];
    
    // Query to check if the logged-in user is a manager
    $query = "SELECT IsManager FROM Users WHERE EmpID = $empID";
    $result = @mysqli_query($dbc, $query);
    $user = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    //Update the transaction customer late fees. Run updateLateFees.php only once per day
    $lastRunFile = '../../lastLateFeeRun.txt';

    $shouldRun = true;
    if (file_exists($lastRunFile)) {
        $lastRunTime = file_get_contents($lastRunFile);
        if (date('Y-m-d', strtotime($lastRunTime)) === date('Y-m-d')) {
            $shouldRun = false;
        }
    }

    if ($shouldRun) {
        include_once('../scripts/updateLateFees.php');
        file_put_contents($lastRunFile, date('Y-m-d H:i:s'));
    }

    echo ('<div class="dashboard">
    <a href="/BCR/htdocs/transactions/add.php" class="button btn_newTrans"><i class="fa-solid fa-cash-register fa-xl"></i><br><br>New Transaction</a>
    <a href="/BCR/htdocs/transactions/index.php" class="button btn_newTrans"><i class="fa-solid fa-chart-simple fa-xl"></i><br><br>Transactions</a>
    <a href="/BCR/htdocs/movies/index.php" class="button btn_newTrans"><i class="fa-solid fa-compact-disc fa-xl"></i><br><br>Movies</a>
    <a href="/BCR/htdocs/customers/index.php" class="button btn_newTrans"><i class="fa-solid fa-user fa-xl"></i><br><br>Customers</a>');

    if (!$user || $user['IsManager'] == 1) {
        // If the user is  a manager, display links to manager level pages
        echo('<!--Managers only-->
            <a href="/BCR/htdocs/employees/index.php" class="button btn_newTrans"><i class="fa-solid fa-user fa-xl"></i><br><br>Employees</a>
            <a href="/BCR/htdocs/reports/index.php" class="button btn_newTrans"><i class="fa-solid fa-chart-simple fa-xl"></i><br><br>Reports</a>');
    }

    echo('</div>');
}
include ('../includes/footer.php');
?>
