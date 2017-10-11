<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to the database
	$password = NULL; //Password used to connect to the database

	$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	$oldTestName = $_POST['oldTestName'];
	$testName = $_POST['testName']; //Getting the entered testname
	$chapterName = $_POST['chapterName']; //Getting the entered chaptername
	$completeTestName = $chapterName."_".$testName;
	
	if(preg_replace('/\s+/', '', $testName) == "" || preg_replace('/\s+/', '', $chapterName) == ""){
		header("Location: clonedTest.php?acessor=admin&testName=".$oldTestName);
		die;
	}
	
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
		
		$sql = "SELECT numMCQ, numEssay, timeLimit FROM form WHERE formNo = \"".$oldTestName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		
		//Constructing an sql query to insert the new information into the database
		echo $sql = "INSERT INTO form (formNo, chapter, numMCQ, numEssay, flag, timeLimit) VALUES (\"".$chapterName."_".$testName."\",\"".$chapterName."\",".$result[0].",".$result[1].",".$flag.",".$result[2].")";
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
			
			$sql = "CREATE TABLE ".$chapterName."(SrNo INT UNSIGNED PRIMARY KEY,
			TestName VARCHAR(700))";
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
		
		echo $sql = "CREATE TABLE ".$completeTestName." LIKE ".$oldTestName;
		$data = mysqli_query($conn, $sql); //Executing the query
		
		echo $sql = "INSERT INTO ".$completeTestName." SELECT * FROM ".$oldTestName;
		$data = mysqli_query($conn, $sql); //Executing the query
		
		header("Location: cloneTest.php?acessor=admin"); //Redirecting to the next page
		die; //Terminating this page
	}
?>