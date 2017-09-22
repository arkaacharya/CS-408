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
	<title>Add New Test</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Add New Test</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
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

	<!-- Textarea to accept the number of MCQ -->
	<tr>
		<td><font size="+2" face="arial"> Enter Number of Multiple Choice Questions (Greater than 0): </font size="+2"></td>
		<td
		align  = "left">
			<input type = "number"
			name = "numMCQ"
			/></td>
	</tr>

	<!-- Textarea to accept the number of essay questions -->
	<tr>
		<td><font size="+2" face="arial"> Enter Number of Essay Questions (Greater than 0): </font size="+2"></td>
		<td
		align  = "left">
			<input type = "number"
			name = "numEssay"
			/></td>
	</tr>

	<!-- Textarea to accept the time limit -->
	<tr>
		<td><font size="+2" face="arial"> Enter Time Limit in Minutes (Greater than 0): </font size="+2"></td>
		<td
		align  = "left">
			<input type = "number"
			name = "timeLimit"
			/></td>
	</tr>

	<tr>
	<td><font size="+2" face="arial" color="red"></br> Note: Please don't leave any of the above fields blank. </font></td>
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
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			//Checking if everything has been set
			if(isset($_POST['testName']) && isset($_POST['chapterName']) && isset($_POST['numMCQ']) && isset($_POST['numEssay']) && isset($_POST['timeLimit'])){

				$testName = preg_replace('/\s+/', '', $_POST['testName']); //Getting the entered testname
				$chapterName = preg_replace('/\s+/', '', $_POST['chapterName']); //Getting the entered chaptername
				$numMCQ = preg_replace('/\s+/', '', $_POST['numMCQ']); //Getting the entered number of MCQ
				$numEssay = preg_replace('/\s+/', '', $_POST['numEssay']); //Getting the entered essay questions
				$timeLimit = preg_replace('/\s+/', '', $_POST['timeLimit']); //Getting the entered time limit
				
				$completeTestName = $chapterName."_".$testName;
				
				//Constructing an sql query to check if the test already exists
				$sql = "SELECT * FROM form WHERE formNo = \"".$chapterName."_".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
				
				if($result){ //Checking if information was returned
					header("Location: testAlreadyExists.php?acessor=admin"); //Redirecting to the error page
					die; //Terminating this page
				}
				else{
					$flag = 1; //Initializing flag
					//constructing an sql query to get the number of the test
					$sql = "SELECT formNo FROM form";
					$data = mysqli_query($conn, $sql); //Executing the query
					$result = mysqli_fetch_row($data); //Extracting information from the executed query
					while($result){ //Condition to loop as long as information is being passed
						$flag++; //Incrementing the flag
						$result = mysqli_fetch_row($data); //Extracting information from the executed query
					}
					//Constructing an sql query to insert the new information into the database
					$sql = "INSERT INTO form (formNo, chapter, numMCQ, numEssay, flag, timeLimit) VALUES (\"".$chapterName."_".$testName."\",\"".$chapterName."\",".$numMCQ.",".$numEssay.",".$flag.",".$timeLimit.")";
					$data = mysqli_query($conn, $sql);  //Executing the query
					
					$sql = "SELECT chapter FROM chapters WHERE chapter = \"".$chapterName."\"";
					$data = mysqli_query($conn, $sql); //Executing the query
					$result = mysqli_fetch_row($data); //Extracting information from the executed query
					if(!$result){
						$flag = 1;
						//constructing an sql query to get the chapter name
						$sql = "SELECT chapter FROM chapters";
						$data = mysqli_query($conn, $sql); //Executing the query
						$result = mysqli_fetch_row($data); //Extracting information from the executed query
						while($result){
							$flag++;
							$result = mysqli_fetch_row($data); //Extracting information from the executed query
						}
						//Constructing an sql query to store the name of the chapter
						$sql = "INSERT INTO chapters (chapter, flag, numForm) VALUES (\"".$chapterName."\",".$flag.", 1)";
						$data = mysqli_query($conn, $sql); //Executing the query
						
						$sql = "CREATE TABLE ".$chapterName."(SrNo INT UNSIGNED,
						TestName VARCHAR(700) PRIMARY KEY)";
						$data = mysqli_query($conn, $sql); //Executing the query
						
						$sql = "INSERT INTO ".$chapterName." (SrNo, TestName) VALUES (1, \"".$completeTestName."\")";
						$data = mysqli_query($conn, $sql); //Executing the query
					}
					else{
						//Constructing an sql query to get the number of exams for the chapter
						$sql = "SELECT numForm FROM chapters WHERE chapter=\"".$chapterName."\"";
						$data = mysqli_query($conn, $sql); //Executing the query
						$result = mysqli_fetch_row($data); //Extracting information from the executed query
						$numForm = $result[0]+1; //Incrementing the number fo chapters
						
						//Constructing an sql to update the number of tests in the database
						$sql = "UPDATE chapters SET numForm = ".$numForm." WHERE chapter=\"".$chapterName."\"";
						$data = mysqli_query($conn, $sql); //Executing the query
						
						$sql = "INSERT INTO ".$chapterName." (SrNo, TestName) VALUES (".$numForm.", \"".$completeTestName."\")";
						$data = mysqli_query($conn, $sql); //Executing the query
					}
					
					header("Location: addTest.php?acessor=admin&testName=".$chapterName."_".$testName); //Redirecting to the next page
					//die; //Terminating this page
				}
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