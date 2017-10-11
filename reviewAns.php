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
	action = "selectUser.php?acessor=admin&redirect=reviewAns"
	method = "post">
	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Review Client Answers</h1></header></center></font>
	<div id="insideBody">
	
	<?php
	
		$userName = $_GET['userName'];
		$testName = $_GET['testName'];
	
		//Creating an sql query to get the number of MCQ in the particular exam
		$sql = "SELECT numMCQ FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$numMCQ = mysqli_fetch_row($data); //Extracting information from the executed query
	
	?>
	
	<!-- Displaying all the data in a table -->
	<table>
	
	<font size="+2" face="arial">
	
	<tr>
	Username: <?php echo $userName; ?>
	</tr>
	</br></br>
	
	<tr>
	Test Name: <?php echo $testName; ?>
	</tr>
	</br></br>
	
	<?php
		for($i=1; $i<=$numMCQ[0]; $i++){
			//Creating an sql query to get the number of MCQ in the particular exam
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i;
			$data = mysqli_query($conn, $sql);
			$result = false;
			if($data){
				$result = mysqli_fetch_row(mysqli_query($conn, $sql));
			}
			
			//Creating an sql query to get all the answers of the user for this exam
			$sql = "SELECT ans".$i." FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$userAns = mysqli_fetch_row($data); //Extracting information from the executed query
			
			if($result[8] != $userAns[0]){
		?>
		<font color = "red" face="arial">
		<?php
			}
			else{
		?>
		<font color = "black" face="arial">
		<?php
			}
	?>
	
	<tr>
		<b>Question
		<?php
			echo " ".$i.": ".$result[1];
			if($result[2]){ clearstatcache();
				?> </br><img src="<?php echo "Pictures/".$testName."/ques".$i.".jpg?".time(); ?>"> <?php
			}
		?></b>
		
		</br></br>a)
		<?php
		echo " ".$result[4];
		?>
		
		</br></br>b)
		<?php
		echo " ".$result[5];
		?>
		
		</br></br>c)
		<?php
		echo " ".$result[6];
		?>
		
		</br></br>d)
		<?php
		echo " ".$result[7];
		?>
		
		</br></br>Correct Answer:
		<?php
		echo " ".$result[8];?>
		
		</br></br>User Answer:
		<?php
		echo " ".$userAns[0];
		?>
		</br></br>
	</tr>
	</font>
	<?php
		}
	?>
	
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "OK" /></td>
	</tr>
	</font>
	</table>

	<!-- Redirecting to the previous page -->
	<font size="+2" face="arial"><a href="selectUser.php?acessor=admin&redirect=reviewAns">Back</a></font size="+2">
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