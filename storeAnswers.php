<?php
	$servername = "localhost"; //Name of server
	$dbname = "OnTheExamLine"; //Name of database
	$username = "root"; //Username used to connect to database
	$password = NULL; //Password used to connect to database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to databace
	if($conn->error){ //Checking the connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	if(isset($_POST['userName']) && isset($_POST['testName'])){ //Checking if the username and testname has been passed
		$userName = $_POST['userName']; //Getting the value of the username
		$testName = $_POST['testName']; //Getting the value of the test name
	}
	else{
		header("Location: login.php"); //Redirecting to the login page
		die; //Terminating this page
	}
	
	//Constructing an sql query to get the login value corresponding to the received username
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$isLoggedIn = $result[0]; //Storing the login value in another variable
	
	if($isLoggedIn){ //Checking the condition to display the webpage
?>
	<html>
	<head>
	<head>
	<body>
	<form>

	<?php
	
		$corrAns=0;
		$numMCQ=0;
		$finalPer=0;
		$sql = "SELECT testTaken FROM useranswers WHERE formNo = \"".$testName."\" AND username=\"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$testTaken = mysqli_fetch_row($data);
	
		if(!$testTaken[0]){
			//Constructing an sql query to get the number of MCQ and Essay questions
			$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$results = mysqli_fetch_row($data); //Extracting information from the executed query
			
			$numMCQ = $results[0]; //Storing the number of MCQ
			$numEssay = $results[1]; //Storing the number of essay
			$corrAns = 0; //Initializing variable

			for ($i = 1; $i <= $numMCQ; $i++){ //Loop to check if all the answers are correct
				//Constructing an sql query to check if the coulmn for the answer is there
				$sql = "SELECT ans".$i." FROM useranswers";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$res = false; //Initializing the variable
				if($data){ //Checking if the query was executed properly
					$res = mysqli_fetch_row($data);	 //Extracting information from the executed query
				}

				//Constructing an sql query to get the correct answer of the corresponding question
				$sql = "SELECT corrAns FROM ".$testName." WHERE quesNum = ".$i."";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$adminAns = mysqli_fetch_row($data); //Extracting information from the executed query
				
				if($res){ //Checking if the column is there
					if(isset($_POST['ans'.$i])){ //Checking if the answer has been entered
						//Constructing an sql query to insert the answer of the user in the correct position
						$sql = "UPDATE useranswers SET ans".$i."=\"".$_POST['ans'.$i]."\" WHERE username='".$userName."' AND formNo='".$testName."'";
						$data = mysqli_query($conn, $sql); //Executing the query
						if($_POST['ans'.$i] == $adminAns[0]) //Checking if the answer entered by the user is correct
							$corrAns++; //Incrementing counter
					}
					else if(isset($_GET['ans'.$i])){ //Checking if the answer has been entered
						//Constructing an sql query to insert the answer of the user in the correct position
						$sql = "UPDATE useranswers SET ans".$i."=\"".$_GET['ans'.$i]."\" WHERE username='".$userName."' AND formNo='".$testName."'";
						$data = mysqli_query($conn, $sql); //Executing the query
						if($_GET['ans'.$i] == $adminAns[0]) //Checking if the answer entered by the user is correct
							$corrAns++; //Incrementing counter
					}
				}
				else{
					//Constructing an sql query to add the appropriate column in the table
					$sql = "ALTER TABLE useranswers ADD ans".$i." VARCHAR(1) NOT NULL DEFAULT '';";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					if(isset($_POST['ans'.$i])){ //Checking if the answer has been entered
						//Constructing an sql query to insert the answer of the user in the correct position
						$sql = "UPDATE useranswers SET ans".$i."='".$_POST['ans'.$i]."' WHERE username='".$userName."' AND formNo='".$testName."'";
						$data = mysqli_query($conn, $sql); //Executing the query
						if($_POST['ans'.$i] == $adminAns[0]) //Checking if the answer entered by the user is correct
							$corrAns++; //Incrementing counter
					}
				}
			}
			
			for($i = 1; $i <= $numEssay; $i++){ //Loop for entering the essay answers into the database
				//Constructing an sql query to check if the appropriate column exists
				$sql = "SELECT ansEssay".$i." FROM useranswers";
				$data = mysqli_query($conn, $sql); //Executing the query
				$res = false; //Initializing the variable
				if($data){ //Checking if the query was executed
					$res = mysqli_fetch_row($data); //Extracting information from the executed query
				}
				
				if($res){ //Checking if information was received
					if(isset($_POST['ansEssay'.$i])){ //Checking if the answer was entered
						//Constructing an sql query to insert the answer of the user in the correct position
						$sql = "UPDATE useranswers SET ansEssay".$i."=\"".$_POST['ansEssay'.$i]."\" WHERE username='".$userName."' AND formNo='".$testName."'";
						$data = mysqli_query($conn, $sql); //Executing the query
					}
				}
				else{
					//Constructing an sql query to add the appropriate column in the table
					$sql = "ALTER TABLE useranswers ADD ansEssay".$i." VARCHAR(300);";
					$data = mysqli_query($conn, $sql); //Executing the query
					
					//Constructing an sql query to insert the answer of the user in the correct position
					if(isset($_POST['ansEssay'.$i])){ //Checking if the answer was entered
						$sql = "UPDATE useranswers SET ansEssay".$i."='".$_POST['ansEssay'.$i]."' WHERE username='".$userName."' AND formNo='".$testName."'";
						$data = mysqli_query($conn, $sql); //Executing the query
					}
				}
			}
			
			//Constructing an sql query to store the total correct answers
			$sql = "UPDATE useranswers SET totalCorrect=".$corrAns." WHERE username='".$userName."' AND formNo='".$testName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
			

				//Constructing an sql query to store the final percentage
				$sql = "UPDATE useranswers SET finalPercentage=".($finalPer=($corrAns*100/$numMCQ))." WHERE username='".$userName."' AND formNo='".$testName."'";
				$data = mysqli_query($conn, $sql); //Executing the query


			//Constructing an sql query to to mark the test as completed
			$sql = "UPDATE useranswers SET testTaken=true WHERE username='".$userName."' AND formNo='".$testName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
		}
		else{
			$sql = "SELECT finalPercentage, totalCorrect FROM useranswers WHERE formNo = \"".$testName."\" AND username=\"".$userName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$results = mysqli_fetch_row($data);
			$corrAns = $results[1];
			$finalPer = $results[0];
			
			$sql = "SELECT numMCQ FROM form WHERE formNo = \"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$numMCQ = $results[0];
		}
		//Redirecting to the next page
		header("Location: results.php?userName=".$userName."&numCorr=".$corrAns."&totalQues=".$numMCQ."&finalPer=".$finalPer."&testNum=".$testName);
		die; //Terminating this page
	?>

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