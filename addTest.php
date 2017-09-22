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
	<title>Add New Test</title> <!-- Name on tab of webpage -->

	</head>
	<body>
	<?php
		$testName = $_GET['testName']; //Getting the testName
	?>
	<form
	action = "storeQuestions.php?acessor=admin"
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Add New Test</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<!-- Puting the name of the test, but making it invisible so that users can not change it -->
	<tr>
		<td
		align  = "left">
			<textarea
			name = "testName"
			size = "700"
			maxlength = "700"
			style = "display: none"
			><?php echo $testName ?></textarea>
			</td>
	</tr>

	<?php
		//Creating an sql query to get the number of MCQ and the number of essay questions
		$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$numMCQ = $result[0]; //Storing the number of MCQ in a separate variable
		$numEssay = $result[1]; //Storing the number of essay questions in a separate variable
		
		for($i = 1; $i <= $numMCQ; $i++){ //Loop for displaying all the spaces MCQ questions
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i; //Creating an sql query to get all the information of a question
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result=false; //Initializing result
			if($data){ //Checking if the query was executed
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
	?>

	<tr>
		<!-- Accepting the question -->
		<td><b><font size="+2" face="arial">Question <?php echo $i." " ?> (Max 300 characters): </font></b></td>
		<td
		align  = "left">
			<textarea
			name = "ques<?php echo $i?>"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50">
			<?php
			if($result){
				echo $result[1];
			}
			?>
			</textarea></td>
	</tr>

	<!-- Accepting option 'a' -->
	<tr>
		<td><font face="arial"> Option a (Max 300 characters): </font></td>
		<td
		align  = "left">
			<textarea
			name = "opt<?php echo $i?>a"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50"
			><?php
			if($result){
				echo $result[5];
			}
			?></textarea></td>
	</tr>

	<!-- Accepting option 'b' -->
	<tr>
		<td><font face="arial"> Option b (Max 300 characters): </font></td>
		<td
		align  = "left">
			<textarea
			name = "opt<?php echo $i?>b"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50"
			><?php
			if($result){
				echo $result[7];
			}
			?></textarea></td>
	</tr>

	<!-- Accepting option 'c' -->
	<tr>
		<td><font face="arial"> Option c (Max 300 characters): </font></td>
		<td
		align  = "left">
			<textarea
			name = "opt<?php echo $i?>c"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50"
			><?php
			if($result){
				echo $result[9];
			}
			?></textarea></td>
	</tr>

	<!-- Accepting option 'd' -->
	<tr>
		<td><font face="arial"> Option d (Max 300 characters): </font></td>
		<td
		align  = "left">
			<textarea
			name = "opt<?php echo $i?>d"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50"
			><?php
			if($result){
				echo $result[11];
			}
			?></textarea></td>
	</tr>

	<!-- Accepting the correct answer -->
	<tr>
		<td><font face="arial"> Correct Answer (Max 1 characters): </font></td>
		<td
		align  = "left">
			<input type = "text"
			name = "ans<?php echo $i?>"
			size = "1"
			maxlength = "1"
			value = "<?php if($result){echo $result[13];} ?>"
			/></td>
	</tr>

	<?php
		}
		
		for($i = 1; $i <= $numEssay; $i++){ //Loop to accept all essay questions
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".($i+$numMCQ); //Creating sql query to get all the information of a question
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result=false; //Initializing $result
			if($data){ //Checking if the query was executed
				$result = mysqli_fetch_row($data); //Extracting information from executed query
			}
	?>

	<tr>
		<!-- Accepting the essay question -->
		<td colspan = "1"><b><font size="+2" face="arial">Essay Question <?php echo $i." " ?> (Max 300 characters): </font></b></td>
		<td
		align  = "left"
		colspan = "3">
			<textarea
			name = "quesEssay<?php echo $i?>"
			size = "300"
			maxlength = "300"
			rows = "2"
			cols = "50"
			><?php if($result){echo $result[1];} ?></textarea></td>
	</tr>

	<tr>
		<!-- Accepting the essay question -->
		<td colspan = "1"><font face="arial">Answer <?php echo $i." " ?> (Max 700 characters): </font></td>
		<td
		align  = "left"
		colspan = "3">
			<textarea
			name = "ansEssay<?php echo $i?>"
			size = "700"
			maxlength = "700"
			rows = "2"
			cols = "50"
			><?php if($result){echo $result[1];} ?></textarea></td>
	</tr>

	<?php
		}
	?>

	<!-- Button used to turn in all the values entered -->
	<tr>
		<td
		colspan = "2"
		align  = "left">
			<input type = "submit"
			value = "Add Questions" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="newTest.php?acessor=admin">Back</a></font>
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