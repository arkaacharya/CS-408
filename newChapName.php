<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to the database
	$password = NULL; //Password used to connect to the database

	$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	$acessor = $_GET['acessor'];
	
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"admin\""; //Constructing an sql query to get the login value of admin
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result1 = mysqli_fetch_row($data); //Extracting information from the executed query
	
	$isLoggedIn = false; //Storing the information in a new variable
	
	if($result1[0]){
		$isLoggedIn = true;
	}
	
	if($isLoggedIn && $acessor=='admin'){ //Checking the conditions to display the webpage
		$chapter = $_GET['chapter']; //Getting the name of the test
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
	
	<font size="+2" face="arial"><center><header><h1>Change Chapter Name</h1></header></center></font>

	<div id="insideBody">
	
	<div id="bodyContent">
	
	<table border = "0">
	
	<!-- Area for entering the number of essay questions -->
	<tr>
		<td><font size="+2" face="arial"> Enter New Chapter Name (Max 600 characters): </font></td>
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
		<font size="+2" face="arial"><a href="modChapName.php?acessor=admin">Back</a></font>
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
			$newName = preg_replace('/\s+/', '', $_POST['newName']);
			if($newName != ""){
				$sql = "SELECT chapter FROM chapters WHERE chapter=\"".$newName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data);
				if(!$result){
					$sql = "UPDATE form SET chapter = \"".$newName."\" WHERE chapter = \"".$chapter."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "UPDATE chapters SET chapter = \"".$newName."\" WHERE chapter = \"".$chapter."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "UPDATE useranswers SET chapterName = \"".$newName."\" WHERE chapterName = \"".$chapter."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "ALTER TABLE ".$chapter." RENAME TO ".$newName."";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					
					$sql = "SELECT TestName FROM ".$newName;
					$data = mysqli_query($conn, $sql); //Executing the sql query
					$result = mysqli_fetch_row($data);
					while(isset($result[0])){
						$newTestName = str_replace($chapter, $newName, $result[0]);
						
						$sql = "UPDATE ".$newName." SET TestName = \"".$newTestName."\" WHERE TestName = \"".$result[0]."\"";
						$data = mysqli_query($conn, $sql); //Executing the sql query
						
						$sql = "UPDATE form SET formNo = \"".$newTestName."\" WHERE formNo = \"".$result[0]."\"";
						$data = mysqli_query($conn, $sql); //Executing the sql query
						
						$sql = "UPDATE useranswers SET formNo = \"".$newTestName."\" WHERE formNo = \"".$result[0]."\"";
						$data = mysqli_query($conn, $sql); //Executing the sql query
						
						$sql = "ALTER TABLE ".$result[0]." RENAME TO ".$newTestName."";
						$data = mysqli_query($conn, $sql); //Executing the sql query
						
						$result = mysqli_fetch_row($data);
					}
					
					$sql = "SELECT username FROM users";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					$result = mysqli_fetch_row($data);
					while(isset($result[0])){
						if($result[0] != 'admin'){
							$sql = "UPDATE ".$result[0]." SET chapter = \"".$newName."\" WHERE chapter = \"".$chapter."\"";
							$data = mysqli_query($conn, $sql); //Executing the sql query
						}
						$result = mysqli_fetch_row($data);
					}
					
					header("Location: modChapName.php?acessor=admin");
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