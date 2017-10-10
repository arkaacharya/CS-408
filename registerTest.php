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
		
		$conn = new mysqli($servername, $username, $password, $dbname); //Establishing a connection to the database
		if($conn->error){ //Checking the connection for errors
			die("Could not establish connection to database."); //Terminating this page
		}
		
		$userName = $_POST['userName'];
		$testName = $_GET['testNum'];
		$chapterName = $_GET['chapName'];

		//Constructing an sql query to check if the user has started the exam already
		$sql = "SELECT * FROM useranswers WHERE username=\"".$userName."\" AND chapterName=\"".$chapterName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		if(!$result){
			$i=1; //Initializing counter
			//Constructing an sql query to get an entry from useranswers
			$sql = "SELECT * FROM useranswers";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){ //Condition to loop as long as information is being received
				$i++; //Incrementing the counter
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
			
			//Constructing an sql query to insert into useranswers the information anout the user and the test
			$sql = "INSERT INTO useranswers (SrNo, username, chapterName, formNo) VALUES(".$i.", \"".$userName."\",\"".$chapterName."\",\"".$testName."\")";
			$data = mysqli_query($conn, $sql); //Executing the query
		}
		else{
			//Constructing an sql query to update the test name for the user
			$sql = "UPDATE useranswers SET formNo=\"".$testName."\" WHERE username='".$userName."' AND chapterName='".$chapterName."'";
			$data = mysqli_query($conn, $sql); //Executing the query
		}
		
		header("Location: displayExam.php?userName=".$userName."&testNum=".$testName); //Redirecting to the exam page
		die; //Terminating this page
	?>
</form>
</body>
</html>