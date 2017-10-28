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
	
	if($isLoggedIn){ //Checking the condition to display the webpage
?>
	<html>
	<head>
		<!-- Name on tab of page -->
		<title>Results</title>
		
	<head>
	<body>
	<form
	action = "userOption.php?userName=<?php echo $userName; ?>"
	method = "post">

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Report Card</h1></header></center>
	<header> <?php echo "Name: ".$name; ?>
	</br><?php echo "Username: ".$userName; ?></header></font>
	<div id="insideBody">
	
	<table border = "0">

	<?php
		$testNum = $_GET['testNum']; //Getting the name of the exam
		$totalQues = $_GET['totalQues']; //Getting the number of questions
		$totalCorr = $_GET['numCorr']; //Getting the number of correct answers
		$finalPer = $_GET['finalPer']; //Getting the final percentage
	?>

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

	<!-- Displaying the test name -->
	<tr>
		<td><font size="+2" face="arial"> Form: <?php echo $testNum ?></font size="+2"></td>
	</tr>

	<!-- Displaying the number of MCQ -->
	<tr>
		<td><font size="+2" face="arial"> Total Multiple Choice Questions: <?php echo $totalQues ?></font size="+2"></td>
	</tr>

	<!-- Displaying the number of correct answers -->
	<tr>
		<td><font size="+2" face="arial"> Correct Answers: <?php echo $totalCorr ?></font size="+2"></td>
	</tr>

	<!-- Displaying the final percentage -->
	<tr>
		<td><font size="+2" face="arial"> Percentage: <?php echo $finalPer."%" ?></font size="+2"></td>
	</tr>

	<tr>
		<td><font size="+2" face="arial" color="red"> Note: This is the percentage for Multiple Choice Questions.
		</br>The final percentage can change after grading the essay questions. </font size="+2"></td>
	</tr>
	
	<!-- Button used to move on to the next page after viewing the results -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "OK" /></td>
	</tr>

	</table>
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
<!-- JavaScript file used to disable the back button so that the user's can't retake the test 
<script>
history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
});
</script>
-->