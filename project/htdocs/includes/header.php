<html>
<style>
<?php include 'style.css'; ?>
</style>
<body><center>


		<Table id="nav" width="100%" cellpadding="10"><tr><td align="right">

		<?
if (!isset($_SESSION['empid']) && !isset($_SESSION['email'])){
			echo (" 	
			
			<ul><a href='../Home/index.php'><img src='../includes/logo.png' id='logo' alt='logo'/></a>	
			<li><a href='../Home/index.php'>Home</a></li>
			<li style='float:right'><a id='loginLogout' href='../Home/logincustomer.php'>Customer Login</a></li>
			<li style='float:right'><a id='loginLogout' href='../Home/login.php'>Employee Login</a></li>
			</ul>");

		} 
		elseif(isset($_SESSION['email'])){
    
			$email = $_SESSION['email'];
			echo ("
			<ul><a href='../Home/index.php'><img src='../includes/logo.png' id='logo' alt='logo'/></a>		
			<li><a href='../Home/index.php'>Home</a></li>
			<li><a href='../transactions/customers.php'>My Transactions</a></li>
			<li><a href='../movies/index.php'>Movies</a></li>");
			echo("
			<li style='float:right'><a id='loginLogout' href=../Home/logout.php>Logout</a></li>
			</ul>");
		}
		
		else {
			// Get the logged-in user's EmpID
			$empID = $_SESSION['empid'];
			
    		// Include the database connection
			require_once ('../../mysqli_connect.php');
			
			// Query to check if the logged-in user is a manager
			$query = "SELECT IsManager FROM Users WHERE EmpID = $empID";
			$result = @mysqli_query($dbc, $query);
			$user = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
			echo ("
					<ul><a href='../Home/index.php'><img src='../includes/logo.png' id='logo' alt='logo'/></a>		
					<li><a href='../Home/index.php'>Home</a></li>
					<li><a href='../transactions/add.php'>New Transaction</a></li>
					<li><a href='../transactions/index.php'>Transactions</a></li>
					<li><a href='../movies/index.php'>Movies</a></li>
					<li><a href='../customers/index.php'>Customers</a></li>");
					
			if (!$user || $user['IsManager'] == 1) {
				echo("
				<li><a href='../employees/index.php'>Employees</a></li>
				<li><a href='../reports/index.php'>Reports</a></li>")	;
			}
			echo("
			<li style='float:right'><a id='loginLogout' href=../Home/logout.php>Logout</a></li>
			</ul>");

		} 
		?>

		<p></td></tr></table>
