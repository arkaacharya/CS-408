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
	<title>Select User</title> <!-- Name on tab of webpage -->
	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of Webpage -->
	<font size="+2" face="arial"><center><header><h1>Select Username</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<!-- Group of Radio buttons with usernames of all the users -->
	<tr>
		<font size="+2" face="arial">Select Username:</font>
		<?php
			$sql = "SELECT username FROM users"; //Constructing an sql query to get the login value of admin
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){
				if($result[0] != "admin"){
		?>
			</br><font size="+2" face="arial"><input type = "radio" name = "username" value = "<?php echo $result[0]?>"/><?php echo $result[0]?> <!-- Displaying username -->
			</font>
			<?php
				}
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
			?>
	</tr>

	<!-- Button used to turn in the selected username -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Select User" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['username'])){ //Checking if the username has been selected
				$userName = $_POST['username']; //Getting the value of the username
				header("Location: addUserChap.php?acessor=admin&userName=".$userName); //Redirecting to the next page
				die; //Terminating this page
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