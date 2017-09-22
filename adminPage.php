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
		<title>Admin Page</title> <!-- Name on the tab of webpage -->

	<head>
	<body>
	<form
	action = "adminRedirect.php"
	method = "post">

	<!-- Title of webpage -->
	<font size="+2" face="arial"><center><header><h1>Administrator Page</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<font size="+2" face="arial">
	<!-- Options for the administrator in the form of radiobuttons -->
	<tr>
		Choose Action:
		</br><input type = "radio" name = "adminOpt" value = "addUser"/>Add New User
		</br></br><input type = "radio" name = "adminOpt" value = "modUser"/>Edit Existing User
		</br></br><input type = "radio" name = "adminOpt" value = "addChap"/>Add Chapter for Existing User
		</br></br><input type = "radio" name = "adminOpt" value = "delUser"/>Delete Existing User
		</br></br><input type = "radio" name = "adminOpt" value = "newTest"/>Add New Test
		</br></br><input type = "radio" name = "adminOpt" value = "cloneTest"/>Clone Existing Test
		</br></br><input type = "radio" name = "adminOpt" value = "modTest"/>Modify Existing Test
		</br></br><input type = "radio" name = "adminOpt" value = "modChapName"/>Change Chapter Name
		</br></br><input type = "radio" name = "adminOpt" value = "delTest"/>Delete Existing Test
		</br></br><input type = "radio" name = "adminOpt" value = "gradeTest"/>Grade Test
		</br></br><input type = "radio" name = "adminOpt" value = "reviewAns"/>Review Client Answers
		</br></br><input type = "radio" name = "adminOpt" value = "reviewPerformance"/>Review Client Performance
		</br></br><input type = "radio" name = "adminOpt" value = "reviewStats"/>Review Test Statistics
	</tr>
</font>
	<!-- Button to submit the administrator's choice -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	</table>
		<!-- Redirecting to the logout page -->
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