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
	<title>Test Statistics</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Test Statistics</h1></header></center></font>
	<div id="insideBody">
	
	<table border = "0">
	
	<tr><td>
		<font size="+2" face="arial">Test Name: <?php echo $testName = $_GET['testName']; ?></font size="+2">
	</td></tr>
		
		<?php
			$sql = "SELECT MIN(finalPercentage) FROM useranswers WHERE formNo='".$testName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			$min = $result[0];
			
			$sql = "SELECT MAX(finalPercentage) FROM useranswers WHERE formNo='".$testName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			$max = $result[0];
			
			$sql = "SELECT AVG(finalPercentage) FROM useranswers WHERE formNo='".$testName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			$avg = $result[0];
		?>
		
	<tr><td>
		<font size="+2" face="arial">Maximum Score: <?php echo $max; ?></font size="+2">
	</td></tr>

	<tr><td>
		<font size="+2" face="arial">Minimum Score: <?php echo $min; ?></font size="+2">
	</td></tr>

	<tr><td>
		<font size="+2" face="arial">Average Score: <?php echo $avg; ?></font size="+2">
	</td></tr>	
	
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="reviewTest.php?acessor=admin">Back</a></font size="+2">
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