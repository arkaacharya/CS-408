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
	<title>Storing Questions</title>
	</head>
	<body>
	<?php
		$testName = $_POST['testName']; //Getting the value of testName
		
		//Constructing an sql query to get the number of MCQ and essay questions
		$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		$numMCQ = $result[0]; //Storing the number of MCQ
		$numEssay = $result[1]; //Storing the number of essay questions

		//Constructing an sql query to create a table which will store all the questions and options
		$sql = "CREATE TABLE ".$testName."(quesNum INT UNSIGNED PRIMARY KEY,
		question VARCHAR(300),
		isMCQ BOOLEAN,
		isEssay BOOLEAN,
		opta VARCHAR(300),
		optb VARCHAR(300),
		optc VARCHAR(300),
		optd VARCHAR(300),
		corrAns VARCHAR(1),
		ansEssay VARCHAR(700))";
		$data = mysqli_query($conn, $sql); //Executing the query

		for($i = 1; $i <= $numMCQ; $i++){ //Loop to store all the MCQ
			//Checking if all parts of the questions have been entered
			if(!($_POST['ques'.$i] == "" || $_POST['opt'.$i.'a'] == "" || $_POST['opt'.$i.'b'] == "" || $_POST['opt'.$i.'c'] == "" || $_POST['opt'.$i.'d'] == "" || $_POST['ans'.$i] == "")){
				//Constructing an sql query to store the question and the answers
				$sql = "INSERT INTO ".$testName." (quesnum, question, isMCQ, isEssay, opta, optb, optc, optd, corrAns) VALUES (\"".$i."\",\"".$_POST['ques'.$i]."\",true,false,\"".$_POST['opt'.$i.'a']."\",\"".$_POST['opt'.$i.'b']."\",\"".$_POST['opt'.$i.'c']."\",\"".$_POST['opt'.$i.'d']."\",\"".$_POST['ans'.$i]."\")";
				$data = mysqli_query($conn, $sql); //Executing the query
			}
		}
		
		for($i = 1; $i <= $numEssay; $i++){ //Loop to store all the essay questions
			if(!($_POST['quesEssay'.$i] == "") && !($_POST['ansEssay'.$i] == "")){ //Checking if the question has been entered
				//Constructing an sql query to store the question
				$sql = "INSERT INTO ".$testName." (quesnum, question, isMCQ, isEssay, ansEssay) VALUES (\"".($i+$numMCQ)."\",\"".$_POST['quesEssay'.$i]."\",false,true,\"".$_POST['ansEssay'.$i]."\")";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				echo $sql;
				echo "Storing essay question   ";
			}
		}
		
		$check = true; //Initializing check
		for($i = 1; $i <= $numMCQ; $i++){ //Loop to check if all the questions have been entered
			if($_POST['ques'.$i] == "" || $_POST['opt'.$i.'a'] == "" || $_POST['opt'.$i.'b'] == "" || $_POST['opt'.$i.'c'] == "" || $_POST['opt'.$i.'d'] == "" || $_POST['ans'.$i] == ""){
				$check = false; //Changing check value
			}
		}
		
		if($check){ //Checking check value
			header("Location: newTest.php?acessor=admin"); //Redirecting to the next page
			die; //Terminating this page
		}
		else{
			header("Location: addTest.php?acessor=admin&testName=".$testName); //Redirecting to the previous page
			die; //Terminating this page
		}
	?>
	</body>
	</html>
<?php
	}
	else{
		header("Location: login.php"); //Redirecting to the login page
		die; //Terminating this page
	}
?>