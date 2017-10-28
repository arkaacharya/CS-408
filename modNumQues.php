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
	<title>Change Number of Questions</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Change Number of Questions</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Area for entering the number of multiple choice questions -->
	<tr>
		<td><font size="+2" face="arial"> Enter New Number of Multiple Choice Questions </font></td>
		<td
		align  = "center">
			<input type = "number"
			name = "numMCQ"
			/></td>
	</tr>

	<!-- Area for entering the number of essay questions -->
	<tr>
		<td><font size="+2" face="arial"> Enter New Number of Essay Questions </font></td>
		<td
		align  = "center">
			<input type = "number"
			name = "numEssay"
			/></td>
	</tr>

	<!-- Button to turn in the data entered -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	</table>
	
	</br><font size="+2" face="arial" color="red"> Please enter a value greater than 0 for at least one of the fields. </font>
	
		<!-- Redirecting to the previous page -->
		</br></br>
	<font size="+2" face="arial"><a href="modOptTest.php?acessor=admin&testName=<?php echo $testName;?>">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['numMCQ']) && isset($_POST['numEssay'])){ //Checking if both of them have been set
				$numMCQ = preg_replace('/\s+/', '', $_POST['numMCQ']); //Getting the number of MCQ
				$numEssay = preg_replace('/\s+/', '', $_POST['numEssay']); //Getting the number of essay questions
				
				//Constructing an sql query to get the previous number of MCQ and essay questions
				$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting the information from the executed query
				$numMCQOld = $result[0]; //Storing the old number of MCQ
				$numEssayOld = $result[1]; //Storing the old number of Essay questions
				
				if($numMCQ == ""){
					$numMCQ = $numMCQOld;
				}
				
				if($numEssay == ""){
					$numEssay = $numEssayOld;
				}
				
				if($numMCQ == 0 && $numEssay == 0){
					header("Location: modNumQues.php?acessor=admin&testName=".$testName); //Redirecting to the next page
					die; //Terminating this page
				}
				
				//Constructing an sql query to store the new number of MCQ and essay questions
				$sql = "UPDATE form SET numMCQ=".$numMCQ.", numEssay=".$numEssay." WHERE formNo = \"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				
				if($numMCQ < $numMCQOld){ //Checking if the number of old questions is more than the number of new questions
					$numQues = $numMCQ+1; //Incrementing the variable
					//Constructing an sql query to check if the question is an MCQ or not
					$sql = "SELECT isMCQ FROM ".$testName." WHERE quesNum=".$numQues;
					$data = mysqli_query($conn, $sql); //Executing the sql query
					$result = mysqli_fetch_row($data); //Extracting the information from executed query
					while($result){ //Condition to loop as long as information is being returned
						if($result[0]){ //Checking if it is an MCQ or not
							//Constructing an sql query to delete the appropriate question
							$sql = "DELETE FROM ".$testName." WHERE quesNum=".$numQues;
							$data = mysqli_query($conn, $sql); //Executing the query
						
							$numQues = $numQues+1; //Incrementing the variable
							//Creating an sql query to check if there are any questions after this current one
							$sql = "SELECT quesNum FROM ".$testName." WHERE quesNum=".$numQues;
							$data = mysqli_query($conn, $sql); //Executing query
							$result_new = mysqli_fetch_row($data); //Extracting information from the executed query
							while($result_new){ //Condition to loop as long as information is being received
								//Creating an sql query to update the question number of the next question
								$sql = "UPDATE ".$testName." SET quesNum=".($numQues-1)." WHERE quesNum=".$numQues;
								$data = mysqli_query($conn, $sql); //Executing the query
								$numQues++; //Incrementing the number of questions
								//Craeting an sql query to check if there is another question
								$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$numQues;
								$data = mysqli_query($conn, $sql); //Executing the query
								$result_new = mysqli_fetch_row($data); //Extracting the information from the query
							}
						}
						
						//Creating an sql query to check if the next question is an MCQ
						$sql = "SELECT isMCQ FROM ".$testName." WHERE quesNum=".$numQues;
						$data = mysqli_query($conn, $sql); //Executing the query
						$result = mysqli_fetch_row($data); //Extracting the information from the executed query
					}
					
					$numQues = $numMCQ+1+$numEssay; //Modifying the value of variable
					//Constructing an sql query to check if the question is an essay question
					$sql = "SELECT isEssay FROM ".$testName." WHERE quesNum=".$numQues;
					$data = mysqli_query($conn, $sql); //Executing the query
					$result = mysqli_fetch_row($data); //Extracting the information from the executed query
					while($result && $result[0]){ //Condition to loop as long as information is being returned
						//Constructing an sql query to delete the appropriate question
						$sql = "DELETE FROM ".$testName." WHERE quesNum=".$numQues;
						$data = mysqli_query($conn, $sql); //Executing the query
						$numQues++; //Incrementing the variable
						//Constructing an sql query to check if the question is an essay question
						$sql = "SELECT isEssay FROM ".$testName." WHERE quesNum=".$numQues;
						$data = mysqli_query($conn, $sql); //Executing the query
						$result = mysqli_fetch_row($data); //Extracting the information from the executed query
					}
				}
				else{
					$numQues = $numMCQOld + $numEssayOld; //Storing total number of old questions
					$newNumQues = $numMCQ + $numEssay;  //Storing total number of new questions
					//Constructing an sql query to check if the question is an essay question or not
					$sql = "SELECT isEssay FROM ".$testName." WHERE quesNum=".$numQues;
					$data = mysqli_query($conn, $sql); //Executing the query
					$result = mysqli_fetch_row($data); //Extracting information from the executed query
					while($result && $result[0]){ //Condition to loop as long as there is information passed and if the questions is an essay question
						//Constructing an sql query to update the question number of the current question
						$sql = "UPDATE ".$testName." SET quesNum=".$newNumQues." WHERE quesNum=".$numQues;
						$data = mysqli_query($conn, $sql); //Executing the query
						
						$numQues--; //Decrementing the variable
						$newNumQues--; //Decrementing the variable
						
						//Constructing an sql query to check whether the next question is an essay question
						$sql = "SELECT isEssay FROM ".$testName." WHERE quesNum=".$numQues;
						$data = mysqli_query($conn, $sql); //Executing the query
						$result = mysqli_fetch_row($data); //Extracting information from the executed query
					}
				}
				
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