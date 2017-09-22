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
	<title>Enter Data</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Enter New Data</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<!-- Area to enter new password -->
	<tr>
		<td><font size="+2" face="arial"> Username  (Max 50 characters):</font size="+2"></td>
		<td
		align  = "center">
			<input type = "text"
			name = "userName"
			size = "20"
			maxlength = "50"/></td>
	</tr>
	
	<!-- Area to enter new password -->
	<tr>
		<td><font size="+2" face="arial"> Password  (Max 20 characters):</font size="+2"></td>
		<td
		align  = "center">
			<input type = "text"
			name = "password"
			size = "20"
			maxlength = "20"/></td>
	</tr>

	<!-- Area to enter new password -->
	<tr>
		<td><font size="+2" face="arial"> Real Name  (Max 50 characters):</font size="+2"></td>
		<td
		align  = "center">
			<input type = "text"
			name = "Name"
			size = "20"
			maxlength = "50"/></td>
	</tr>
	
	<!-- Button used to submit all the entered data -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Modify Data" /></td>
	</tr>
	</table>
	
	<font size="+2" face="arial" color = "red">Note: Do not use special characters for username.</font>
	
		</br></br>
		<!-- Redirects to the previous page -->
	<font size="+2" face="arial"><a href="modUser.php?acessor=admin">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			$userName = $_GET['username']; //Getting the value of the user's username
			
			if(isset($_POST['password']) && preg_replace('/\s+/', '', $_POST['password']) != ""){
				//Constructing an sql query to update the password of the user
				$sql = "UPDATE users SET password = \"".$_POST['password']."\" WHERE username = \"".$userName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
			}
			
			if(isset($_POST['Name']) && preg_replace('/\s+/', '', $_POST['Name']) != ""){
				//Constructing an sql query to update the access type of the user
				$sql = "UPDATE users SET name = \"".$_POST['Name']."\" WHERE username = \"".$userName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
			}
			
			if(isset($_POST['userName']) && preg_replace('/\s+/', '', $_POST['userName']) != ""){
				$newUserName = preg_replace('/\s+/', '', $_POST['userName']);
				$sql = "SELECT username FROM users WHERE username=\"".$newUserName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data);
				if($result){
					header("Location: userAlreadyExists.php?acessor=admin"); //Redirecting to the next page
					die; //Terminating this page
				}
				else{
					$sql = "UPDATE users SET username = \"".$newUserName."\" WHERE username = \"".$userName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "UPDATE useranswers SET username = \"".$newUserName."\" WHERE username = \"".$userName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "ALTER TABLE ".$userName." RENAME TO ".$newUserName."";
					$data = mysqli_query($conn, $sql); //Executing the sql query
				}
			}
			
			if(isset($_POST['password']) || isset($_POST['name']) || isset($_POST['userName'])){ //Checking if any of them are set
				header("Location: modUser.php?acessor=admin"); //Redirecting to the next page
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