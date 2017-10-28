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
	<title>Delete Question</title> <!-- Name on the tab of the page -->

	</head>
	<body>
	<form
	action = "quesDel.php"
	method = "post"
	>
	<!-- Title of the page -->
	<font size="+2" face="arial"><center><header><h1>Delete Existing Question</h1></header></center></font>

	<div id="insideBody">
	
	<?php
		$testName = $_GET['testName']; //Getting the name of the test
	?>

	<tr>
	<!-- Used for the testname as it is easier to submit this way.
		It has been nade invisible so that the test taker can't modify it.-->
		<td
		align  = "left">
			<textarea
			name = "testName"
			size = "700"
			maxlength = "700"
			readonly = "readonly"
			style = "display: none"
			><?php echo $testName ?></textarea>
			
			</td>
	</tr>
	
	<table border = "0">
	<tr><td>
	<!-- Displaying the questions as a group of radio buttons -->
		<font size="+2" face="arial">Select Question:</font>
		<?php  
			$i = 1; //Used as a counter
			$sql = "SELECT question FROM ".$testName." WHERE quesNum=".$i; //Constructing an sql query to get the question from the corresponding table
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
			while($result){ //Condition to loop as long as information is being received
		?>
		<!-- Displaying the question with a radio button -->
		</br><input type = "radio" name = "quesNum" value = "<?php echo $i ?>"/><font size="+2" face="arial">
		<?php
		echo $i.": ".$result[0]; //Displaying the question

				$i++; //Incrementing the counter
				$sql = "SELECT question FROM ".$testName." WHERE quesNum=".$i.""; //Constructing an sql query to get the next question
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
	?>
	<td>
	</tr>

	<!-- Button used to submit the selected question -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Delete Question" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="modOptTest.php?acessor=admin&testName=<?php echo $testName; ?>">Back</a></font>
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
		die; //Termianting this page
	}
?>