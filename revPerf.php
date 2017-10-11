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
	<title>Review Performance</title>

	</head>
	<body>
	<form
	action = "adminPage.php?acessor=admin">
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Review Client Performance</h1></header></center></font>
	<div id="insideBody">
	<!-- Displaying all the data in a table -->
	<table border = "1">

	<tr>
		<td align = "center"><font size="+2" face="arial">Name</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">Username</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">Test Name</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">Time Stamp</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">MCQ Grade</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">Essay Grade</font size="+2"></td>
		<td align = "center"><font size="+2" face="arial">Final Percentage</font size="+2"></td>
		
	</tr>

	<?php
		//Constructing an sql query to get the user's information
		$sql = "SELECT name, username FROM users";
		$data2 = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data2); //Extracting information from the executed query
		while($result){ //Condition to loop as long as data is being received
			if($result[1] != 'admin1' && $result[1] != 'admin2' && $result[1] != 'admin3'){
				//Constructing an sql query to check if the user has taken an exam
				$sql = "SELECT * FROM useranswers WHERE username = \"".$result[1]."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$resultAns = mysqli_fetch_row($data); //Extracting information from the executed query
				
				if($resultAns){ //Checking if any information was received
					$i = 1; //Another counter
					//Constructing an sql query to get the results of the user
					$sql = "SELECT username, formNo, completionTime, totalCorrect, totalEssayGrade, achievedEssayGrade, finalPercentage FROM useranswers WHERE SrNo = \"".$i."\"";
					$data = mysqli_query($conn, $sql); //Executing the query
					$resultAns = mysqli_fetch_row($data); //Extracting information from the executed query
					
					//Constructing an sql query to get the user's information
					$sql = "SELECT * FROM users WHERE username = \"".$resultAns[0]."\"";
					$data = mysqli_query($conn, $sql); //Executing the query
					$resultUser = mysqli_fetch_row($data); //Extracting information from the executed query
					
					//Constructing an sql query to get the number of MCQ
					$sql = "SELECT numMCQ FROM form WHERE formNo = \"".$resultAns[1]."\"";
					$data = mysqli_query($conn, $sql); //Executing the sql query
					$resultMCQ = mysqli_fetch_row($data); //Extracting information from the executed query
					
					while($resultAns){ //Condition to loop as long as information is being received
						if(($resultAns[0] == $result[1])){ //Checking if this is the information of the wanted user
				?>

				<!-- Displaying the grades of the user -->
				<tr>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultUser[0]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[0]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[1]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[2]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[3]."/".$resultMCQ[0]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[5]."/".$resultAns[4]?></font size="+2"></td>
					<td align = "center"><font size="+2" face="arial"><?php echo $resultAns[6]."%"?></font size="+2"></td>
				</tr>

				<?php
						}
						$i++; //Incermenting counter
						
						//Constructing an sql query to get the results of the user
						$sql = "SELECT username, formNo, completionTime, totalCorrect, totalEssayGrade, achievedEssayGrade, finalPercentage FROM useranswers WHERE SrNo = \"".$i."\"";
						$data = mysqli_query($conn, $sql); //Executing the query
						$resultAns = mysqli_fetch_row($data); //Extracting information from the executed query
						
						//Constructing an sql query to get the user's information
						$sql = "SELECT * FROM users WHERE username = \"".$resultAns[0]."\"";
						$data = mysqli_query($conn, $sql); //Executing the query
						$resultUser = mysqli_fetch_row($data); //Extracting information from the executed query
						
						//Constructing an sql query to get the number of MCQ
						$sql = "SELECT numMCQ FROM form WHERE formNo = \"".$resultAns[1]."\"";
						$data = mysqli_query($conn, $sql); //Executing the query
						$resultMCQ = mysqli_fetch_row($data); //Extracting information from the executed query
					}
				}
				else{
					if($result[1] != 'admin'){ //Checking if the username is a match
					?>
					<!-- Displaying user information only -->
					<tr>
						<td align = "center"><font size="+2" face="arial"><?php echo $result[0]?></font size="+2"></td>
						<td align = "center"><font size="+2" face="arial"><?php echo $result[1]?></font size="+2"></td>
						<td align = "center"><font size="+2" face="arial">N/A</font size="+2"></td>
						<td align = "center"><font size="+2" face="arial">N/A</font size="+2"></td>
						<td align = "center"><font size="+2" face="arial">N/A</font size="+2"></td>
						<td align = "center"><font size="+2" face="arial">N/A</font size="+2"></td>
						<td align = "center"><font size="+2" face="arial">N/A</font size="+2"></td>
					</tr>
					<?php
					}
				}
			}
			$result = mysqli_fetch_row($data2); //Extracting information from the executed query
		}
	?>
	</table>

	<!-- Redirecting to the previous page -->
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>
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