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
		<title>Grade Essay Questions</title> <!-- Name on tab of page -->

	<head>
	<body>
	<form
	action = "inputFinalGrade.php?acessor=admin"
	method = "post">

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Grade Essay Questions</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<?php
		$userName = $_GET['userName']; //Getting the value of the user's username
		$testName = $_GET['testName']; //Getting the value of the tste's name
	?>

	<!-- Used for the username as it is easier to submit this way.
		It has been nade invisible so that the test taker can't modify it.-->
	<tr>
		<td>
			<input type = "text"
			name = "userName"
			value = <?php echo $userName;?>
			style = "display: none"
			readonly />
		</td>
	</tr>

	<!-- Used for the testname as it is easier to submit this way.
		It has been nade invisible so that the test taker can't modify it.-->
	<tr>
		<td>
			<input type = "text"
			name = "testName"
			value = <?php echo $testName;?>
			style = "display: none"
			readonly />
		</td>
	</tr>

	<tr><td>
		<?php
			$i = 1; //Used as a counter
			//Constructing an sql query to get the answer entered by the user
			$sql = "SELECT ansEssay".$i." FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			
			//Constructing an sql query to get the number of MCQ
			$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo=\"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$numMCQ = mysqli_fetch_row($data); //Extracting the information from the executed query
			
			//Constructing an sql query to get the question
			$sql = "SELECT question, ansEssay FROM ".$testName." WHERE quesNum=\"".($numMCQ[0] + $i)."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$essayQues = mysqli_fetch_row($data); //Extracting information from the executed query
			
			while(($i <= $numMCQ[1]) && ($numMCQ[1] > 0)){ //Condition to loop as long as information is being received
		?>
		<b><font size="+2" face="arial">Essay Question <?php echo $i;?>: <?php echo" ".$essayQues[0] ?>
		<?php
			if($essayQues[2]){ clearstatcache();
				?> </br><img src="<?php echo "Pictures/".$testName."/ques".$i.".jpg?".time(); ?>"> <?php
			}
		?>
		</font></b> <!-- Displaying question -->
		</br></br><font size="+2" face="arial">Correct Answer: <?php echo " ".$essayQues[1];?></font> <!-- Displaying answer -->
		</br></br><font size="+2" face="arial">User Answer: <?php echo " ".$result[0];?></font> <!-- Displaying answer -->
		</br></br><font size="+2" face="arial">Given Grade:</font><input type = "number" name = "essay<?php echo $i;?>Grade"/> <!-- Area for entering earned grade -->
		</br></br><font size="+2" face="arial">Max Possible:</font><input type = "number" name = "essay<?php echo $i;?>MaxGrade"/></br></br> <!-- Area for entering max grade -->
		</br></br>
		<?php
				$i++; //Incrementing counter
				//Constructing an sql query to get the answer entered by the user
				$sql = "SELECT ansEssay".$i." FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				if($data){ //Checking if execution was successful
					$result = mysqli_fetch_row($data);//Extracting information from the executed query
				}
				else{
					$result = false;
				}
				
				//Constructing an sql query to get the question
				$sql = "SELECT question, ansEssay FROM ".$testName." WHERE quesNum=\"".($numMCQ[0] + $i)."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$essayQues = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		?>
		</td>
	</tr>

	<!-- Button used to submit all the scores -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	
	</table>
	
	<font size="+2" face="arial"><a href="selectTest.php?acessor=admin&userName=<?php echo $userName; ?>&redirect=gradeTest">Back</a></font>
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