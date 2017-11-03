<html>
<head>
<head>
<body>
<form>
	<?php
		$servername = "localhost"; //Name of server
		$dbname = "OnTheExamLine"; //name of database
		$username = "root"; //Username used to connect to the database
		$password = NULL; //Password used to connect to the database
		
		$userName = $_GET['uName']; //Getting the user's username
		$chapterName = $_GET['chapterName']; //Getting the passed chapter name
	
		$conn = new mysqli($servername, $username, $password, $dbname); //Establishing a connection to the database
		if($conn->error){ //Checking the connection for errors
			die("Could not establish connection to database."); //Terminating this page
		}
		
		//Constructing an sql query to check if the user has taken an exam from this chapter already
		$sql = "SELECT chapterName FROM useranswers WHERE username = \"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query

		if($data == false){ //Checking if the query was executed
			header("Location: notEligibleForTest.php?userName=".$userName); //Redirecting to the error page
			die; //Terminating this page
		}

		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		if($result){ //Checking if any information was passed
			$i=1; //Used as a counter
			$eligible = true; //Initializing a boolean variable
			//Constructing an sql query to get an entry from the table useranswers
			$sql = "SELECT * FROM useranswers WHERE SrNo=".$i."";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){ //Condition to loop as long as information is being received
				//Checking if the username chaptername and if the test has been completed
				if($result[1] == $userName && $result[2] == $chapterName && $result[9] == true){
					$eligible = false; //Changing the value of boolean variable
				}
				$i++; //Incrementing the counter
				//Constructing an sql query to get the next entry in the useranswers table
				$sql = "SELECT * FROM useranswers WHERE SrNo=".$i."";
				$data = mysqli_query($conn, $sql); //Executing the query
				$result = mysqli_fetch_row($data); //Exxtracting the information from the executed query
			}
			if(!$eligible){ //Checking eligibility
				header("Location: notEligibleForTest.php?userName=".$userName); //Redirecting to error page
				die; //Terminating this page
			}
		}
		
		//Constructing an sql query to get the number of exams for the selected chapter
		$sql = "SELECT numForm FROM chapters WHERE chapter = \"".$chapterName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$numForm = $result[0];
		$randomNum = rand(1, $numForm); //Selecting a random number between 1 and the upper limit specified by $result[0]
		
		$sql = "SELECT TestName FROM ".$chapterName." WHERE SrNo = \"".$randomNum."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$testName = $result[0]; //Getting the testname
		
		header("Location: testConf.php?userName=".$userName."&testNum=".$testName); //Redirecting to the exam page
		die; //Terminating this page
	?>
</form>
</body>
</html>