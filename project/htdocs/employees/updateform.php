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

    // Get the employee ID from the session
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

    // Continue with the rest of your code, as the user is a manager
    // Check if the employee ID is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $empID = $_GET['id'];
    } else {
        echo "Invalid Employee ID.";
        exit();
    }

    // Fetch the employee details from the database
    $query = "SELECT * FROM Users WHERE EmpID = $empID";
    $result = @mysqli_query($dbc, $query);
    $employee = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$employee) {
        echo "Employee not found.";
        exit();
    }

    echo '<style>
            form{
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
    if (isset($_POST['updateEmployee'])) {
        // Sanitize the inputs
        $empID = $_POST['empID'];
        $firstName = mysqli_real_escape_string($dbc, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($dbc, $_POST['lastName']);
        $phone = mysqli_real_escape_string($dbc, $_POST['phone']);
        $streetAdr = mysqli_real_escape_string($dbc, $_POST['streetAdr']);
        $city = mysqli_real_escape_string($dbc, $_POST['city']);
        $state = mysqli_real_escape_string($dbc, $_POST['state']);
        $zip = mysqli_real_escape_string($dbc, $_POST['zip']);
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
        $salary = $_POST['salary'];
        $workHours = $_POST['workHours'];
        $isManager = $_POST['isManager'];

        // Perform the update query excluding the password
        $updateQuery = "UPDATE Users SET 
                            FirstName = '$firstName',
                            LastName = '$lastName',
                            Phone = '$phone',
                            StreetAdr = '$streetAdr',
                            City = '$city',
                            State = '$state',
                            Zip = '$zip',
                            Email = '$email',
                            Salary = '$salary',
                            WorkHours = '$workHours',
                            IsManager = '$isManager'
                        WHERE EmpID = $empID";

        $updateResult = @mysqli_query($dbc, $updateQuery);

        if ($updateResult) {
            echo "<h2 style='margin-bottom:1%;'>" .$employee['FirstName']." ".$employee['LastName']." has been updated.</h2>"; 
        } else {
            echo "<h2>Error updating employee: " . mysqli_error($dbc) . "</h2>";
        }
    } else {
        // Display the employee update form
        echo ("<h1 class='pagetitle'>Update Employee</h1>");
        echo "<form action='updateform.php?id=$empID' method='POST'>
                <input type='hidden' name='empID' value='".$employee['EmpID']."'>
                <label for='firstName'>First Name:</label><br>
                <input type='text' id='firstName' name='firstName' value='".$employee['FirstName']."' required size='50'>

                <label for='lastName'>Last Name:</label><br>
                <input type='text' id='lastName' name='lastName' value='".$employee['LastName']."' required size='50'>

                <label for='phone'>Phone:</label><br>
                <input type='text' id='phone' name='phone' value='".$employee['Phone']."' size='50'>

                <label for='streetAdr'>Street Address:</label><br>
                <input type='text' id='streetAdr' name='streetAdr' value='".$employee['StreetAdr']."' size='50'>

                <label for='city'>City:</label><br>
                <input type='text' id='city' name='city' value='".$employee['City']."' size='50'>

                <label for='state'>State:</label><br>
                <input type='text' id='state' name='state' value='".$employee['State']."' size='50'>

                <label for='zip'>Zip Code:</label><br>
                <input type='text' id='zip' name='zip' value='".$employee['Zip']."' size='50'>

                <label for='email'>Email:</label><br>
                <input type='text' id='email' name='email' value='".$employee['Email']."' size='50'>

                <label for='salary'>Salary:</label><br>
                <input type='text' id='salary' name='salary' value='".$employee['Salary']."' size='50'>

                <label for='workHours'>Work Hours:</label><br>
                <input type='text' id='workHours' name='workHours' value='".$employee['WorkHours']."' size='50'>

                <label for='isManager'>Is Manager:</label><br>
                <select id='isManager' name='isManager'>
                    <option value='1' ".($employee['IsManager'] == 1 ? 'selected' : '').">Yes</option>
                    <option value='0' ".($employee['IsManager'] == 0 ? 'selected' : '').">No</option>
                </select>
                
                <br><br><br>
                <input type='submit' name='updateEmployee' id='updEmployee' value='Update Employee'>
            </form>";
            echo '<p id="searchUpdate"><a href=index.php>Back to Employees</a></p> ';
    }

    // Close the database connection
    mysqli_close($dbc);
}

// Include the footer
include ('../includes/footer.php');
?>
