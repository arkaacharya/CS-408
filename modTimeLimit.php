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
		$testName = $_GET['testName']; //Getting the test name
?>
	<html>
	<head>
	<!-- Name on tab of page -->
	<title>Change Time Limit</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Change Time Limit</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Area for entering new time limit -->
	<tr>
		<td> <font size="+2" face="arial">Enter New Time Limit in Minutes:</font size="+2"> </td>
		<td
		align  = "center">
			<input type = "number"
			name = "timeLimit"
			/></td>
	</tr>
	
	<tr>
	<td><font size="+2" face="arial" color="red"></br>Note: Please enter a value greater than 0.</font></td>
	</tr>

	<!-- Button used to turn in new time limit -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="modOptTest.php?acessor=admin&testName=<?php echo $testName; ?>">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['timeLimit'])){ //Checking if time limit has been entered
				$timeLimit = preg_replace('/\s+/', '', $_POST['timeLimit']); //Getting the time limit entered
				
				//Constructing an sql query to update the new time limit in the database
				$sql = "UPDATE form SET timeLimit=".$timeLimit." WHERE formNo = \"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
				
				header("Location: modOptTest.php?acessor=admin&testName=".$testName); //Redirecting to the next page
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