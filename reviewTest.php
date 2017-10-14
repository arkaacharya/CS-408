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
		$redirect = $_GET['redirect'];
?>
	<html>
	<head>
	<!-- Name on tab of page -->
	<title>Select Test</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Select Test</h1></header></center></font>
	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Displaying the tests as a group of radio buttons -->
	<tr>
		<font size="+2" face="arial">Select Test:</font size="+2">
		<?php
			//Constructing an sql query to check if the user has taken/started a test
			$sql = "SELECT formNo FROM form";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){ //Condition to loop as long as information is being received
							?>
		<!-- Displaying the test name -->
		</br><input type = "radio" name = "testName" value = "<?php echo $result[0] ?>"/><font size="+2" face="arial"><?php echo $result[0] ?></font size="+2">
	</tr>
			<?php
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
	?>

	<!-- Button used to submit the selected test -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Select Test" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['testName'])){ //Checking if a test has been selected
				$testName = $_POST['testName']; //Getting the name of the selected test
				header("Location: displayStats.php?acessor=admin&testName=".$testName); //Redirecting to the appropriate page
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