<?php
session_start();
include("../includes/header.php");

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
    require_once('../../mysqli_connect.php');

    // Check if the logged-in user is a manager
    $empid = $_SESSION['empid']; // Get the current user's EmpID
    $query = "SELECT IsManager FROM Users WHERE EmpID=$empid";
    $result = @mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row['IsManager'] != 1) {
        // If the user is not a manager, deny access
        echo "<h2>You do not have permission to add a user.</h2>";
        include('../includes/footer.php');
        exit();
    }

    // Check if form is submitted
    if (isset($_POST['submit']) && isset($_POST['submitted']) && $_POST['submitted'] == "true") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $salary = $_POST['salary'];  
        $isManager = ($_POST['isManager'] == 'Yes') ? 1 : 0;  // Convert 'Yes' to 1 and 'No' to 0

        // SQL Query to insert data into the Users table
        $query = "INSERT INTO Users (FirstName, LastName, Phone, Email, StreetAdr, City, State, Zip, Salary, isManager) 
                  VALUES ('$firstName', '$lastName', '$phone', '$email', '$address', '$city', '$state', '$zip', '$salary', '$isManager')";

        // Execute the query
        $result = @mysqli_query($dbc, $query);

        // Check if the insert was successful
        if ($result) {
            echo "<center><h2><b>A new user has been added.</b></h2>";
            echo "<p><a href='index.php'>Show Users</a></p></center>";
        } else {
            echo "<p>The record could not be added due to a system error: " . mysqli_error($dbc) . "</p>";
        }
    }
    mysqli_close($dbc);
?>

<style>
    .addform form {
        margin-top: 2%;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .addform input[type=text], select, .addform input[type=tel], .addform input[type=email], .addform input[type=number] {
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
</style>

<h1 class='pagetitle'>Add Employee</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="addform">
    <label for="firstName">First Name</label>
    <input name="firstName" type="text" id="firstName" required>

    <label for="lastName">Last Name</label>
    <input name="lastName" type="text" id="lastName" required>

    <label for="email">Email</label>
    <input name="email" type="email" id="email" required>

    <label for="phone">Phone</label>
    <input name="phone" type="tel" id="phone" required>

    <label for="address">Street Address</label>
    <input name="address" type="text" id="address" required>

    <label for="city">City</label>
    <input name="city" type="text" id="city" required>

    <label for="state">State</label>
    <input name="state" type="text" id="state" required>

    <label for="zip">Zip Code</label>
    <input name="zip" type="text" id="zip" required>

    <label for="salary">Salary</label>
    <input name="salary" type="number" id="salary" required>

    <label for="isManager">Is Manager?</label>
    <select name="isManager" id="isManager" required>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>

    <input type="submit" name="submit" value="Add User">
    <input type="reset" value="Reset">
    <input type="hidden" name="submitted" value="true">
</form>

<p id="searchUpdate"><a href=index.php>Back to Employees</a></p>

<?php

include('../includes/footer.php');
}
?>
