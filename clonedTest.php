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
		$oldTestName = $_GET['testName'];
?>
	<html>
	<head>
	<!-- Name on tab of page -->
	<title>New Test Information</title>

	</head>
	<body>
	<form
	action = "storeClonedTest.php"
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>New Test Information</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
	<tr>
		<td
		align  = "left">
			<input type = "text"
			name = "oldTestName"
			size = "50"
			value="<?php echo $oldTestName ?>"
			readonly = "readonly"
			maxlength = "50"
			style = "display: none"
			/></td>
	</tr>
	
	<!-- Textarea to accept the chapter's name -->
	<tr>
		<td><font size="+2" face="arial"> Enter Chapter Name (No Spaces and Max 600 characters): </font size="+2"></td>
		<td
		align  = "left">
			<textarea
			name = "chapterName"
			size = "600"
			maxlength = "600"
			></textarea>
			</td>
	</tr>

	<!-- Textarea to accept the test's number -->
	<tr>
		<td><font size="+2" face="arial"> Enter Test Number (No Spaces and Max 30 characters): </font size="+2"></td>
		<td
		align  = "left">
			<input type = "text"
			name = "testName"
			size = "30"
			maxlength = "30"/></td>
	</tr>


	<!-- Button to submit the information entered -->
	<tr>
		<td
		colspan = "2"
		align  = "left">
			<input type = "submit"
			value = "Add Test" /></td>
	</tr>
	</table>
	
	<font size="+2" face="arial" color = "red">Note: Do not leave any of the above fields blank.</font>
	
		</br></br>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="cloneTest.php?acessor=admin">Back</a></font size="+2">
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