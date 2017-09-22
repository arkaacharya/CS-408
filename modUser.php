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
	<!-- Name on tab of page -->
	<title>Edit User</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Edit Existing User</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
	<!-- List of usernames dispalyed as a group of radio buttons -->
	<tr>
		<font size="+2" face="arial">Select Username:</font size="+2">
			<?php
				//Constructing an sql query to get the user's username
				$sql = "SELECT username FROM users";
				$data = mysqli_query($conn, $sql); //Executing the query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
				while($result){ //Condition to loop as long as information is being received
					if(($resultComp[0] == $result[1]) && ($result[0] != 'admin')){ //Checking the conditions
			?>
			<!-- Displaying the username -->
			</br><input type = "radio" name = "username" value = "<?php echo $result[0]?>"/><font size="+2" face="arial"><?php echo $result[0]?></font size="+2">
			<?php
					}
					$result = mysqli_fetch_row($data); //Extracting information from the executed query
				}
			?>
	</tr>

	<!-- Button used to submit the selected username -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Modify User" /></td>
	</tr>
	</table>
		<!-- Redirects to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['username'])){ //Checking if a username has been selected
				$userName = $_POST['username']; //getting the value of the selected username

				//Constructing an sql query to check if the user exists
				$sql = "SELECT * FROM users WHERE username = \"".$userName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
				
				if(!$result){ //Checking if information was received
					header("Location: userDoesntExist.php?acessor=admin"); //Redirecting to the error page
					die; //Terminating this page
				}
				else{
					header("Location: modUserData.php?acessor=admin&username=".$userName); //Redirecting to the next page
					die; //Terminating this page
				}
			}
		?>
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