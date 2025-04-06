<?php
session_start();
// Include the header
include ('../includes/header.php');

//check session first
if (!isset($_SESSION['empid'])){// Print a customized message.
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

    // Check if the customer ID is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $customerID = $_GET['id'];
    } else {
        echo "Invalid Customer ID.";
        exit();
    }

    // Fetch the customer details from the database
    $query = "SELECT * FROM Customers WHERE CustID = $customerID";
    $result = @mysqli_query($dbc, $query);
    $customer = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$customer) {
        echo "Customer not found.";
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
    </style>';

    // Check if the form is submitted
    if (isset($_POST['updateCustomer'])) {
        // Sanitize the inputs
        $customerID = $_POST['customerID'];
        $firstName = mysqli_real_escape_string($dbc, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($dbc, $_POST['lastName']);
        $phone = mysqli_real_escape_string($dbc, $_POST['phone']);
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
        $streetAdr = mysqli_real_escape_string($dbc, $_POST['streetAdr']);
        $city = mysqli_real_escape_string($dbc, $_POST['city']);
        $state = mysqli_real_escape_string($dbc, $_POST['state']);
        $zip = mysqli_real_escape_string($dbc, $_POST['zip']);
        $lateFees = $_POST['lateFees'];

        // Perform the update query
        $updateQuery = "UPDATE Customers SET 
                            FirstName = '$firstName',
                            LastName = '$lastName',
                            Phone = '$phone',
                            Email = '$email',
                            StreetAdr = '$streetAdr',
                            City = '$city',
                            State = '$state',
                            Zip = '$zip',
                            LateFees = '$lateFees'
                        WHERE CustID = $customerID";

        $updateResult = @mysqli_query($dbc, $updateQuery);

        if ($updateResult) {
            echo "<h2 style='margin-bottom:1%;'>" .$customer['FirstName']." ".$customer['LastName']." has been updated.</h2>"; 
        } else {
            echo "<h2>Error updating customer: " . mysqli_error($dbc) . "</h2>";
        }
    } else {
        // Display the customer update form
        echo ("<h1 class='pagetitle'>Update Customer</h1>");
        echo "<form action='updateform.php?id=$customerID' method='POST'>
                <input type='hidden' name='customerID' value='".$customer['CustID']."'>
                <label for='firstName'>First Name:</label><br>
                <input type='text' id='firstName' name='firstName' value='".$customer['FirstName']."' required size='50'>

                <label for='lastName'>Last Name:</label><br>
                <input type='text' id='lastName' name='lastName' value='".$customer['LastName']."' required size='50'>

                <label for='phone'>Phone:</label><br>
                <input type='text' id='phone' name='phone' value='".$customer['Phone']."' size='50'>

                <label for='email'>Email:</label><br>
                <input type='text' id='email' name='email' value='".$customer['Email']."' size='50'>

                <label for='streetAdr'>Street Address:</label><br>
                <input type='text' id='streetAdr' name='streetAdr' value='".$customer['StreetAdr']."' size='50'>

                <label for='city'>City:</label><br>
                <input type='text' id='city' name='city' value='".$customer['City']."' size='50'>

                <label for='state'>State:</label><br>
                <input type='text' id='state' name='state' value='".$customer['State']."' size='50'>

                <label for='zip'>Zip Code:</label><br>
                <input type='text' id='zip' name='zip' value='".$customer['Zip']."' size='50'>

                <label for='lateFees'>Late Fees:</label><br>
                <input type='text' id='lateFees' name='lateFees' value='".$customer['LateFees']."' size='50'>
                
                <br><br><br>
                <input type='submit' name='updateCustomer' id='updCustomer' value='Update Customer'>
            </form>";
            echo '<p id="searchUpdate"><a href=index.php>Back to Customers</a></p> ';	  
    }

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include ('../includes/footer.php');
?>
