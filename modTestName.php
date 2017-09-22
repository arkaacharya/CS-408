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
		$testName = $_GET['testName']; //Getting the name of the test
?>
	<html>
	<head>
	<title>Change Test Name</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<font size="+2" face="arial"><center><header><h1>Change Test Name</h1></header></center></font>

	<div id="insideBody">
	
	<div id="bodyContent">
	
	<table border = "0">
	
	<!-- Area for entering the number of essay questions -->
	<tr>
		<td><font size="+2" face="arial"> Enter New Test Name (Max 600 characters): </font></td>
		<td
		align  = "center">
			<input type = "text"
			name = "newName"
			size = "20"
			maxlength = "600"
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
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="modOptTest.php?acessor=admin&testName=<?php echo $testName;?>">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>
	
	</table>
	</div>
	</div>
	</form>

	</body>
	</html>
<?php

		if(isset($_POST['newName'])){
			$newTestName = preg_replace('/\s+/', '', $_POST['newName']);
			if($newTestName != ""){
				$sql = "SELECT chapter FROM form WHERE formNo=\"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data);
			
				$chapter = $result[0];
				$newName = $chapter."_".$newTestName;
				
				$sql = "SELECT chapter FROM form WHERE formNo=\"".$newName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data);
				if($result){
					header("Location: testAlreadyExists.php?acessor=admin"); //Redirecting to the next page
					die; //Terminating this page
				}
				else{
					$sql = "UPDATE form SET formNo = \"".$newName."\" WHERE formNo = \"".$testName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "UPDATE useranswers SET formNo = \"".$newName."\" WHERE formNo = \"".$testName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "ALTER TABLE ".$testName." RENAME TO ".$newName."";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "SELECT chapter FROM form WHERE formNo=\"".$newName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					$result = mysqli_fetch_row($data);
					$chapter = $result[0];
					
					$sql = "UPDATE ".$chapter." SET TestName = \"".$newName."\" WHERE TestName = \"".$testName."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					header("Location: modOptTest.php?acessor=admin&testName=".$newName);
					die;
				}
			}
		}
	}
	else{
		header("Location: login.php");
		die;
	}
?>