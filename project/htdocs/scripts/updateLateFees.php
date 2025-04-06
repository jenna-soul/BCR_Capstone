<?php
require_once('../../mysqli_connect.php');

$query = "SELECT TransID, CustID, DueDate 
          FROM Transactions 
          WHERE ReturnDate IS NULL AND DueDate < CURDATE()";
$result = mysqli_query($dbc, $query);

while ($rental = mysqli_fetch_assoc($result)) {
    $custID = $rental['CustID'];
    $dueDate = new DateTime($rental['DueDate']);
    $today = new DateTime();
    $daysLate = $dueDate->diff($today)->days;
    $lateFee = $daysLate * 1.50;

    $updateQuery = "UPDATE Customers 
                    SET LateFees = LateFees + $lateFee 
                    WHERE CustID = $custID";
    mysqli_query($dbc, $updateQuery);
}
?>
