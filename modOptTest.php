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
	<title>Modify Test</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<font size="+2" face="arial"><center><header><h1>Modify Existing Test</h1></header></center></font>

	<div id="insideBody">
	
	<div id="bodyContent">
	
	<table border = "0">
	
	<tr><td>
		<font size="+2" face="arial">Choose Action:</font size="+2">
		</br><input type = "radio" name = "modOpt" value = "modTestName"/><font size="+2" face="arial">Change Test Name</font>
		</br><input type = "radio" name = "modOpt" value = "modQues"/><font size="+2" face="arial">Change Questions and Options</font>
		</br><input type = "radio" name = "modOpt" value = "modNumQues"/><font size="+2" face="arial">Change Number of Questions</font>
		</br><input type = "radio" name = "modOpt" value = "delQues"/><font size="+2" face="arial">Delete Specific Questions</font>
		</br><input type = "radio" name = "modOpt" value = "modTimeLimit"/><font size="+2" face="arial">Change Time Limit</font>
	</td></tr>

	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	</table>
		<font size="+2" face="arial"><a href="modTest.php?acessor=admin">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['modOpt'])){
				header("Location: ".$_POST['modOpt'].".php?acessor=admin&testName=".$testName.""); //Redirecting to error page
				die;
			}
		?>
	
	<?php
		$sql = "SELECT formNo,timeLimit, numMCQ, numEssay FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql);
		$result = mysqli_fetch_row(mysqli_query($conn, $sql));		
		$timeLimit = $result[1];
		$numMCQ = $result[2];
		$numEssay = $result[3];
	?>
	
	<table>
	
	<tr><td><font size="+2" face="arial"></br></br>Number of Multiple Choice Questions: <?php echo " ".$numMCQ;?></font></br></tr></td>
	<tr><td><font size="+2" face="arial">Number of Essay Questions: <?php echo " ".$numEssay;?></font></br></tr></td>
	</br></br>
	<tr><td><font size="+2" face="arial">Time Limit for Test: <?php echo " ".$timeLimit." ";?> minute(s) </font></br></tr></td>
	
	<?php
		$i = 1;
		$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i;
		$data = mysqli_query($conn, $sql);
		$result = false;
		if($data){
			$result = mysqli_fetch_row(mysqli_query($conn, $sql));
		}		
		while($result && $i <= $numMCQ){
	?>
	<tr><td>
	<font size="+2" face="arial">
		<b></br></br></br>Question
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
	
	<?php
			$i++;
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i;
			$data = mysqli_query($conn, $sql);
			$result = mysqli_fetch_row($data);
		}
	?>
	</font>
	</td>
	</tr>

	<?php
			$i = 1;
			$sql = "SELECT question, ansEssay FROM ".$testName." WHERE quesNum=".($i+$numMCQ);
			$data = mysqli_query($conn, $sql);
			$result = false;
			if($data){
				$result = mysqli_fetch_row(mysqli_query($conn, $sql));
			}
			while($result && $i <= $numEssay){
		?>
	<tr><td>
	<font size="+2" face="arial">
		<b></br></br></br>Essay Question
		<?php
		echo " ".$i.": ".$result[0]." ";
		?></b>
		
		</br></br>Answer
		<?php
		echo " ".$i.": ".$result[1]." ";?>
		
		<?php
				$i++;
				$sql = "SELECT question, ansEssay FROM ".$testName." WHERE quesNum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql);
				$result = mysqli_fetch_row($data);
			}
		?>
	</font>
	</td>
	</tr>
	</table>
	</div>
	</div>
	</form>

	</body>
	</html>
<?php
	}
	else{
		header("Location: login.php");
		die;
	}
?>