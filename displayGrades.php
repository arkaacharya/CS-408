<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to database
	$password = NULL; //Password used to connect to database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to dtabase
	if($conn->error){ //Checking if connection has some errors
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
		die; //Terminating this page
	}
	
	//Constructing sql query to get the corresponding login value of this user
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$isLoggedIn = $result[0]; //Storing the value in another variable
	
	//constructing an sql query to get the name of the user from the apopropriate table
	$sql = "SELECT name FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$name = $result[0]; //Storing the name in another variable
	
	if($isLoggedIn){ //Checking condition to show the rest of the page
?>
	<html>
	<head>
		<title>Grades</title> <!-- Name on tab of page -->

	<head>
	<body>
	<form
	action = "userOption.php?userName=<?php echo $userName; ?>">

	<!-- Title of the page -->
	<font size="+2" face="arial"><center><header><h1>Final Grades</h1></header></center>
	<header> <?php echo "Name: ".$name; ?>
	</br><?php echo "Username: ".$userName; ?></header></font>
	<div id="insideBody">
	
	<table border = "0">
	
	<?php
		$testName = $_GET['testName']; //Getting the name of the test
		
		//Constructing an sql query to get the number of MCQ
		$sql = "SELECT numMCQ FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$numMCQ = $result[0]; //Storing the number in another variable
		
		//Constructing an sql query to get the score of the user from the appropriate table
		$sql = "SELECT totalCorrect, achievedEssayGrade, totalEssayGrade, finalPercentage FROM useranswers WHERE formNo=\"".$testName."\" AND username=\"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$totalCorr = $result[0]; //Storing the number of correct answers
		$totalEssay = $result[2]; //Storing the max essay grade
		$EssayCorr = $result[1]; //Storing the grade of essay questions
		$finalPer = $result[3]; //Storing the final percentage

	?>

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
	
	<!-- Displays the username -->
	<tr>
		<td><font size="+2" face="arial"> Username: <?php echo $userName; ?></font></td>
	</tr>

	<!-- Displays the test name -->
	<tr>
		<td><font size="+2" face="arial"> Form: <?php echo $testName; ?></font></td>
	</tr>

	<!-- Displays the MCQ grade -->
	<tr>
		<td><font size="+2" face="arial"> Multiple Choice Questions: <?php echo $totalCorr; ?> / <?php echo $numMCQ; ?></font></td>
	</tr>


	<?php
		$i = 1; //Used as counter
		//Constructing an sql query to get the score of an individual essay question
		$sql = "SELECT essay".$i."grade, essay".$i."max FROM useranswers WHERE formNo=\"".$testName."\" AND username=\"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		while($result){ //Condition to loop as long as information is being received
			if($result[0]!=NULL && $result[1]!=NULL){ //Checking if the essay questions have been graded
	?>
	<tr>
		<!-- Displaying the essay question grade -->
		<td><font size="+2" face="arial"> Essay Question <?php echo $i;?>: <?php echo $result[0]; ?>/<?php echo $result[1]; ?></font></td>
	</tr>
	<?php
			}
			$i++; //Inceremnting the counter
			//Constructing an sql query to get the score of an individual essay question
			$sql = "SELECT essay".$i."grade, essay".$i."max FROM useranswers WHERE formNo=\"".$testName."\" AND username=\"".$userName."\"";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = false; //Initializing the variable
			if($data){ //Checking if execution of he query was successful
				$result = mysqli_fetch_row($data); //Extracting information from the query
			}
		}
	?>

	<!-- Displaying the total grade of the essay questions -->
	<tr>
		<td><font size="+2" face="arial"> Essay Questions: <?php echo $EssayCorr; ?> / <?php echo $totalEssay; ?></font></td>
	</tr>

	<!-- Displaying the final percentage -->
	<tr>
		<td><font size="+2" face="arial"> Percentage: <?php echo $finalPer; ?></font></td>
	</tr>

	<!-- Button to move forward -->
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