<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to the database
	$password = NULL; //Password used to connect to the database

	$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	$acessor = $_GET['acessor']; //Getting the value of acessor
	
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"admin\""; //Constructing an sql query to get the login value of admin
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result1 = mysqli_fetch_row($data); //Extracting information from the executed query
	
	$isLoggedIn = false; //Storing the information in a new variable
	
	if($result1[0]){
		$isLoggedIn = true;
	}
	
	if($isLoggedIn && $acessor=='admin'){ //Checking the conditions to display the webpage
?>
	<html>
	<head>
	<title>Delete User</title> <!-- Name on tab of page -->

	</head>
	<body>
	<form
	action = "removeUser.php"
	method = "post"
	>
	
	<!-- Title of Webpage -->
	<font size="+2" face="arial"><center><header><h1>Delete Existing User</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Displaying the usernames as a group of radio buttons -->
	<tr><td>
		<font size="+2" face="arial">Select Username:</font>
			<?php
				//Constructing an sql query to get the username
				$sql = "SELECT username FROM users";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting the results fromt he executed query
				while($result){ //Condition to loop till information is being received
					if($result[0] != 'admin'){ //Checking if the the username is not admin
			?>
			<!-- Displaying the username -->
			</br><input type = "radio" name = "username" value = "<?php echo $result[0]?>"/><font size="+2" face="arial"><?php echo $result[0]?></font>
			<?php
					}
					$result = mysqli_fetch_row($data); //Extracting the information from the executed query
				}
			?>
		</td>
	</tr>

	<!-- Button used to submit the selected username -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Delete User" /></td>
	</tr>
	</table>
		<!-- Redirect to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

	</div>
	</form>

	</body>
	</html>
<?php
	}
	else{
		header("Location: login.php"); //Redirecting to the login page
		die; //Terminating this page
	}
?>