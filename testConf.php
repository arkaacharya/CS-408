<?php
	$servername = "localhost"; //Name of server
	$dbname = "OnTheExamLine"; //Name of database
	$username = "root"; //Username used to connect to database
	$password = NULL; //Password used to connect to database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to database
	if($conn->error){ //Checking if connection has error
		die("Could not establish connection to database."); //Terminating this page
	}
	
	if(isset($_GET['userName'])){ //Checking if the username has been set
		$userName = $_GET['userName']; //Getting the value of the username
	}
	else if(isset($_POST['userName'])){ //Checking if the username has been set
		$userName = $_POST['userName']; //Getting the value of the username
	}
	else{
		header("Location: login.php"); //Redirecting to the login page
		die; //Terniminating this page
	}
	
	//Constructing an sql query to get the login value corresponding to the received username
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$isLoggedIn = $result[0]; //Storing the login value in another variable
	
	//constructing an sql query to get the name of the user from the apopropriate table
	$sql = "SELECT name FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$name = $result[0]; //Storing the name in another variable
	
	$testName = $_GET['testNum']; //Getting the name of the exam
	
	if($isLoggedIn){ //Checking the condition to display the webpage
	
		//Constructing an sql query to get the test information
		$sql = "SELECT chapter, numMCQ, numEssay, timeLimit FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
?>
	<html>
	<head>
		<!-- Name on tab of page -->
		<title>Test Confirmation</title>
		

	<head>
	<body>
	<form
	action = "registerTest.php?userName=<?php echo $userName; ?>&testNum=<?php echo $testName ?>&chapName=<?php echo $result[0]; ?>"
	method = "post">

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Test Confirmation</h1></header></center>
	<header> <?php echo "Name: ".$name; ?>
	</br><?php echo "Username: ".$userName; ?></header></font>
	<div id="insideBody">
	
	<table border = "0">

	<!--
	This is used to pass the username as it is required in the next page.
	It has been made invisible here so that the user cannot change it.
	-->
	<tr>
		<td
		align  = "left">
			<input type = "text"
			name = "userName"
			size = "50"
			value="<?php echo $userName ?>"
			readonly = "readonly"
			maxlength = "50"
			style = "display: none"
			/></td>
	</tr>
	
	<!-- Displays the name of the user -->
	<tr>
		<td><font size="+2" face="arial"> Name: <?php echo $name; ?></font></td>
	</tr>
	
	<!-- Displaying the username -->
	<tr>
		<td><font size="+2" face="arial"> Username: <?php echo $userName ?></font size="+2"></td>
	</tr>

	<!-- Displaying the name of the chapter -->
	<tr>
		<td><font size="+2" face="arial"> Chapter: <?php echo $result[0] ?></font size="+2"></td>
	</tr>

	<!-- Displaying the time limit -->
	<tr>
		<td><font size="+2" face="arial"> Time Limit: <?php echo $result[3] ?></font size="+2"></td>
	</tr>
	
	<tr>
		<td><font size="+2" face="arial" color="red">
		<ul>
		Reminders:</br>
		<li>Make sure your laptop is sufficiently charged.</br></li>
		<li>Do not use the back or refresh button of the browser while taking the test.</br></li>
		<li>Do not close the browser window or tab while taking the test.</br></li>
		</ul>
		</font size="+2"></td>
	</tr>
	
	
	<!-- Button used to move on to the next page after viewing the test details -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Start Test" /></td>
	</tr>
	
	</table>
	<!-- Redirecting to the previous page -->
	<font size="+2" face="arial"><a href="testOption.php?userName=<?php echo $userName; ?>">Back</a></font>

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