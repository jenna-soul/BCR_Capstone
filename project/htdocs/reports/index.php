<?php
session_start();
include ('../includes/header.php');
//check session first
if (!isset($_SESSION['empid'])){
    echo("<h2>You are not logged in.</h2>
        <form action='login.php''>
            <input type='submit' name='submit' value='Login'/>
        </form>
    <p><br /><br /></p>");
    
    include ('../includes/footer.php');

	exit();
}else{
    // Include the database connection
    require_once ('../../mysqli_connect.php');
    
    // Get the logged-in user's EmpID
    $empID = $_SESSION['empid'];
    
    // Query to check if the logged-in user is a manager
    $query = "SELECT IsManager FROM Users WHERE EmpID = $empID";
    $result = @mysqli_query($dbc, $query);
    $user = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$user || $user['IsManager'] != 1) {
        // If the user is not a manager, display an error or redirect
        echo "<h2>You do not have permission to view this page.</h2>";
        exit();
    }
    // Display the page content if the user is a manager

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
    
    echo '<script src="https://kit.fontawesome.com/636a12d49d.js" crossorigin="anonymous"></script>';
    
    echo '<div class="dashboard reportbtns">
        <a href="/BCR/htdocs/reports/revenue.php" class="button btn_newTrans"><i class="fa-solid fa-cash-register fa-xl"></i><br><br>Revenue</a>
        <a href="/BCR/htdocs/reports/expenses.php" class="button btn_newTrans"><i class="fa-solid fa-cash-register fa-xl"></i><br><br>Expenses</a>
        </div>';
    echo '<div class="dashboard reportbtns">
        <a href="/BCR/htdocs/reports/inventory-popular.php" class="button btn_newTrans"><i class="fa-solid fa-chart-simple fa-xl"></i><br><br>Inventory - Popular Rentals</a>
        <a href="/BCR/htdocs/reports/inventory-due.php" class="button btn_newTrans"><i class="fa-solid fa-chart-simple fa-xl"></i><br><br>Inventory - Rentals Passed Due Date</a>
        </div>';
    echo '<div class="dashboard reportbtns">
        <a href="#" id="empPerformanceLink" class="button btn_newTrans"><i class="fa-solid fa-user fa-xl"></i><br><br>Employee Performance</a>
        <a href="/BCR/htdocs/reports/payroll.php" class="button btn_newTrans"><i class="fa-solid fa-cash-register fa-xl"></i><br><br>Payroll</a>
        </div>';
    echo '<div class="dashboard reportbtns">
        <a href="/BCR/htdocs/reports/audit.php" class="button btn_newTrans"><i class="fa-solid fa-chart-simple fa-xl"></i><br><br>Login Audit</a>
        </div>';
}
include ('../includes/footer.php');


// Set the current year and month in PHP variables
$currentYear = date('Y');
$currentMonth = date('n'); // Returns the month as a number (1-12)

echo("<script>
    const empPerformanceLink = document.getElementById('empPerformanceLink');
    const url = '/BCR/htdocs/reports/empperformance.php?year={$currentYear}&month={$currentMonth}';
    empPerformanceLink.href = url; // Update the href attribute with the dynamic year and month
    console.log(url); // Output the constructed URL to the console
</script>");

?>
