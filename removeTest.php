<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to the database
	$password = NULL; //Password used to connect to the database

	$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}

	$testName = $_POST['testName']; //Getting the name of the selected test

	$sql = "SELECT flag FROM form WHERE formNo = \"".$testName."\""; //Constructing an sql query to check if the test exists
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	
	if(!$result){ //Checking if any information was received
		header("Location: testDoesntExist.php?acessor=admin"); //Redirecting to the error page
		die; //Terminating this page
	}
	else{
		$flag = ($result[0] + 1); //Incermenting the flag value
		
		//Constructing an sql query to get the chapter corresponding to this test
		$sql = "SELECT chapter FROM form WHERE formNo = \"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$chapter = $result[0]; //Storing the name of the chapter in another variable
		
		$sql = "DELETE FROM form WHERE formNo = \"".$testName."\""; //Constructing an sql query to delete the selected test from the table
		$data = mysqli_query($conn, $sql); //Executing the sql query
		
		//Constructing an sql query to to check for remaining tests in the table
		$sql = "SELECT formNo FROM form WHERE flag = \"".$flag."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		while($result){ //Condition to loop as long as information is being received
			//Constructing an sql query to update the flag value of the remaining tests
			$sql = "UPDATE form SET flag=".($flag-1)." WHERE formNo = \"".$result[0]."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			$flag++; //Inceremnting the flag value
			//Constructing an sql query to to check for remaining tests in the table
			$sql = "SELECT formNo FROM form WHERE flag = \"".$flag."\""; 
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
		}
		
		//Creating an sql query to remove the corresponding table with the questions for this test
		$sql = "DROP TABLE ".$testName;
		$data = mysqli_query($conn, $sql); //Executing the sql query
		
		//Creating an sql query to get the number of exams in the corresponding chapter
		$sql = "SELECT numForm FROM chapters WHERE chapter=\"".$chapter."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$numForm = $result[0]-1; //Reducing th number of exams
		
		//Creating an sql query to update the number of exams in the corresponding chapter
		$sql = "UPDATE chapters SET numForm = ".$numForm." WHERE chapter=\"".$chapter."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		
		$sql = "SELECT SrNo FROM ".$chapter." WHERE TestName=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$SrNo = $result[0]+1;
		
		$sql = "DELETE FROM ".$chapter." WHERE TestName = \"".$testName."\""; //Constructing an sql query to delete the selected test from the table
		$data = mysqli_query($conn, $sql); //Executing the sql query
		
		//Constructing an sql query to to check for remaining tests in the table
		$sql = "SELECT SrNo FROM ".$chapter." WHERE SrNo = \"".$SrNo."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		while($result){ //Condition to loop as long as information is being received
			//Constructing an sql query to update the flag value of the remaining tests
			$sql = "UPDATE ".$chapter." SET SrNo=".($SrNo-1)." WHERE SrNo = \"".$result[0]."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			$SrNo++; //Inceremnting the flag value
			//Constructing an sql query to to check for remaining tests in the table
			$sql = "SELECT SrNo FROM ".$chapter." WHERE SrNo = \"".$SrNo."\""; 
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
		}
		
		// Constructing an sql query to check if there are any exams for the corresponding chapter left
		$sql = "SELECT * FROM form WHERE chapter = \"".$chapter."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		if(!$result){ //Checking if any information was received
			$sql = "SELECT flag FROM chapters WHERE chapter = \"".$chapter."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			echo $flag = $result[0]+1;
			
			
			$sql = "SELECT flag FROM chapters WHERE flag = \"".$flag."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){
				echo $sql = "UPDATE chapters SET flag=".($flag-1)." WHERE flag=".$flag;
				$data = mysqli_query($conn, $sql); //Executing the sql query
				
				$flag++;
				
				$sql = "SELECT flag FROM chapters WHERE flag = \"".$flag."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		
			//Constructing an sql query to remove the corresponding chapter from the database
			$sql = "DELETE FROM chapters WHERE chapter = \"".$chapter."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			$sql = "DELETE FROM useranswers WHERE chapter = \"".$chapter."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			$sql = "DROP TABLE ".$chapter;
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			$sql = "SELECT username FROM users";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while(isset($result[0])){
				$sql = "DELETE FROM ".$result[0]." WHERE chapter = \"".$chapter."\"";
				$data1 = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		}
		
		header("Location: delTest.php?acessor=admin"); //Redirecting to the next page
		die; //Terminating this page
	}
?>