<?php
	$servername = "localhost"; //Name of server
	$dbname = "OnTheExamLine"; //Name of database
	$username = "root"; //Username user to connect to database
	$password = NULL; //Password used to connect to server

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	if(isset($_GET['userName'])){ //Checking if the username has been set
		$userName = $_GET['userName']; //Getting the value of the username
	}
	else if(isset($_POST['userName'])){ //Checking if the username has been set
		$userName = $_POST['userName']; //Getting the value of the username
	}
	else{
		header("Location: login.php"); //Redirecting to the login page
		die; //Terminating this page
	}
	
	$testName = $_GET['testNum']; //Getting the name of the test
	
	//Constructing an sql query to get the corresponding login value of the user
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$isLoggedIn = $result[0]; //Storing the information in another variable
	
	//Constructing a query to check if the test has been already taken by the user
	$sql = "SELECT testTaken FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
	$data = mysqli_query($conn, $sql); //Executing the query
	$testTaken = mysqli_fetch_row($data); //Extracting information from the executed query
	
	//constructing an sql query to get the name of the user from the apopropriate table
	$sql = "SELECT name FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$name = $result[0]; //Storing the name in another variable
	
	if($isLoggedIn && !$testTaken[0]){ //Checking conditions to display the rest of the webpage
?>
	<html>
	<head>
		<!-- Name on tab of the page -->
		<title><?php
		//Constructing an sql query to get the test information
		$sql = "SELECT formNo,timeLimit, numMCQ, numEssay FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$result = mysqli_fetch_row(mysqli_query($conn, $sql)); //Extracting infromation from the executed query
		$timeLimit = $result[1]; //Storing the time limit in another variable
		$numMCQ = $result[2]; //Storing the number of MCQ in another variable
		$numEssay = $result[3]; //Storing the number of essay questions in another variable
		
		echo $testName; //Displaying the test name ?></title>

	<!-- JavaScript used to update the timer -->
	<script>
	var distance = <?php echo $timeLimit; ?>;
	distance = distance * 60;
	var x = setInterval(function() {
		
	  distance = distance - 1;
	  var minutes = Math.floor(distance / 60);
	  var seconds = Math.floor(distance % 60);

	  document.getElementById("timer").innerHTML = minutes + "m "
	  + seconds + "s";

	  // If the count down is finished, write some text 
	  if (distance <= 0) {
		document.forms[0].submit();
	  }
	}, 1000);
	</script>


	<head>
	<body>
	<form
	action = "storeAnswers.php"
	method = "post">

	<!-- Title of the page -->
	<font size="+2" face="arial"><center><header><h1><?php echo $testName; ?></h1></header></center>
	<header> <?php echo "Name: ".$name; ?>
	</br><?php echo "Username: ".$userName; ?></header></font>
	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Used to display the time left on the top of the page -->
	<font size="+2" face="arial"><p id="timer"></p></font>
	
	<tr>
	<!-- Used for the username as it is easier to submit this way.
		It has been nade invisible so that the test taker can't modify it.-->
		<td
		align  = "left">
			<input type = "text"
			name = "userName"
			size = "50"
			value="<?php echo $userName ?>"
			readonly = "readonly"
			maxlength = "50"
			style = "display: none"
			/></td>
	</tr>
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
	
		<?php
			$i = 1; //Used as a counter
			//Constructing an sql query to get the question of the test
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i;
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row(mysqli_query($conn, $sql)); //Extracting information from the executed query
			while($result && $i <= $numMCQ){ //Condition to loop as long as information is being received, and the number of questions haven't been exceeded
		?>
	<tr><td>
		<!-- Displaying the question -->
		<b></br></br></br><font size="+2" face="arial">Question
			<?php
			echo " ".$i.": ".$result[1]; //Displaying the question
			?></b>
		
		<!-- Displaying the option 'a' -->
		</br></br><input type = "radio" name = "ans<?php echo $i ?>" value = "a"/>
		<font size="+2" face="arial"><?php
		echo " ".$result[4]; //Displaying option
		?></font>
		
		<!-- Displaying the option 'b' -->
		</br></br><input type = "radio" name = "ans<?php echo $i ?>" value = "b"/>
		<font size="+2" face="arial"><?php
		echo " ".$result[5]; //Displaying option
		?></font>
		
		<!-- Displaying the option 'c' -->
		</br></br><input type = "radio" name = "ans<?php echo $i ?>" value = "c"/>
		<font size="+2" face="arial"><?php
		echo " ".$result[6]; //Displaying option
		?></font>
		
		<!-- Displaying the option 'd' -->
		</br></br><input type = "radio" name = "ans<?php echo $i ?>" value = "d"/>
		<font size="+2" face="arial"><?php
		echo " ".$result[7]; //Displaying option
		?></font>
		
		<?php
				$i++; //Inceremnting counter
				//Constructing an sql query to get the question of the test
				$sql = "SELECT * FROM ".$testName." WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		?>
	</td></tr>

	<?php
			$i = 1; //Incrementing counter
			//Constructing an sql query to get the question of the test
			$sql = "SELECT * FROM ".$testName." WHERE quesNum=".($i+$numMCQ);
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row(mysqli_query($conn, $sql)); //Extracting information from the executed query
			while($result && $i <= $numEssay){ //Condition to loop as long as information is being received, and the number of questions haven't been exceeded
		?>
	<tr><td>
		<!-- Displaying the question -->
		<b></br></br></br><font size="+2" face="arial">Essay Question
		<?php
		echo " ".$i.": ".$result[1]." "; //Displaying the question
		?></b>
		<!-- Area for accepting the answer -->
		</br>(Answer in maximum 700 characters)</font>
		</br><textarea
			name = "ansEssay<?php echo $i ?>"
			size = "700"
			maxlength = "700"
			></textarea>
		<?php
				$i++; //Incrementing the counter
				//Constructing an sql query to get the question of the test
				$sql = "SELECT * FROM ".$testName." WHERE quesNum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		?>
	</td></tr>

	<!-- Button to turn in all the answers -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit Answers" /></td>
	</tr>
	</table>
	</div>
	</form>

	</body>
	</html>
<?php
	}
	else{
		header("Location: login.php"); //Redirecting tot he login page
		die; //Terminating this page
	}
?>

<!-- JavaScript file used to disable the back button so that the user's can't retake the test -->

<!--
<script>
===== This Disables the back button =====
history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
});
</script>
-->

<script lang uage="javascript"type="text/javascript">//this code handles the F5/Ctrl+F5/Ctrl+R

document.onkeydown = checkKeycode

function checkKeycode(e){var keycode;if(window.event)

keycode = window.event.keyCode;elseif(e)

keycode = e.which;// Mozilla firefoxif($.browser.mozilla){if(keycode ==116||(e.ctrlKey && keycode ==82)){if(e.preventDefault){

e.preventDefault();

e.stopPropagation();}}}// IEelseif($.browser.msie){if(keycode ==116||(window.event.ctrlKey && keycode ==82)){

window.event.returnValue =false;

window.event.keyCode =0;

window.status ="Refresh is disabled";}}}</script>