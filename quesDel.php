<?php
	if(isset($_POST['quesNum'])){ //Checking if a question has been selected
		$quesNum = $_POST['quesNum']; //Getting the question number of the selected question

		$testName = $_POST['testName'];
		
		$servername = "localhost"; //Name of the server
		$dbname = "OnTheExamLine"; //Name of the database
		$username = "root"; //Username used to connect to the database
		$password = NULL; //Password used to connect to the database

		$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
		if($conn->error){ //Checking connection for errors
			die("Could not establish connection to database."); //Terminating this page
		}
		
		$sql = "SELECT quesNum FROM ".$testName." WHERE quesNum = \"".$quesNum."\""; //Constructing an sql query to check if the question exists
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		
		if($result != true){ //Checking if information was received
			//header("Location: questionDoesntExist.php?acessor=admin"); //Redirecting to the error page
			//die; //Terminating this page
		}
		else{
			$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\""; //Constructing an sql query to get the number of MCQ and essay questions
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			$numMCQ = $result[0]; //Storing the number of MCQ in another variable
			$numEssay = $result[1]; //Storing the number of essay questions in another variable
			
			$sql = "SELECT isMCQ FROM ".$testName." WHERE quesNum = \"".$quesNum."\""; //Constructing an sql query to check if the question is MCQ or not
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			$isMCQ = $result[0]; //Storing the information in another variable
			
			if($isMCQ){ //If the question is an MCQ question
				//Constructing an sql query to reduce the total number of MCQ
				$sql = "UPDATE form SET numMCQ=".($numMCQ-1)." WHERE formNo = \"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
			}
			else{
				//Constructing an sql query to reduce the total number of Essay questions
				$sql = "UPDATE form SET numEssay=".($numEssay-1)." WHERE formNo = \"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
			}
			
			//Constructing an sql query to delete the selected question from the table
			$sql = "DELETE FROM ".$testName." WHERE quesNum = \"".$quesNum."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			//Constructing an sql query to get the next question's number
			$sql = "SELECT quesNum FROM ".$testName." WHERE quesNum = \"".($quesNum+1)."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from executed query
			while($result){ //Condition to loop as long as information is being received
				//Constructing an sql query to modify the question number of the existing questions
				$sql = "UPDATE ".$testName." SET quesNum=".($quesNum-1)." WHERE quesNum = \"".$quesNum."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				
				$quesNum++; //Incerementing the counter
				
				//Constructing an sql query to get the number of the next question
				$sql = "SELECT quesNum FROM ".$testName." WHERE quesNum = \"".($quesNum)."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from executed query
			}
			
			header("Location: delQues.php?acessor=admin&testName=".$testName); //Redirecting to the next page
			die; //Terminating this page
		}
	}
?>