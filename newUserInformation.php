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
		<title>Add New User</title>

	<head>
	<body>
	<form
	action = "registerNewUser.php"
	method = "post">

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Add New User</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<tr>
		</br>
		</br>
		<!-- Displaying all the chapters in a group of radio buttons -->
		<font size="+2" face="arial">Chapters:</font size="+2">
		<?php
			//Constructing an sql query to get the name of chapter
			$sql = "SELECT chapter FROM chapters";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$resultChapter = mysqli_fetch_row($data); //Extracting information from the executed query
			while($resultChapter){ //Condition for looping as long as information is being received
		?>
		<!-- Displaying the chapter name with a radio button -->
		</br><font size="+2" face="arial"><input type = "radio" name = "chapter" value = "<?php echo $resultChapter[0] ?>"/><?php echo $resultChapter[0]?></font size="+2">
		<?php
				$resultChapter = mysqli_fetch_row($data); //Extracting information from the query
			}
		?>
	</tr>
	
	<!-- Area to enter the new username -->
	<tr>
		</br></br><td><font size="+2" face="arial"> Username  (Max 50 characters)</font size="+2"></td>
		<td
		align  = "left">
			<input type = "text"
			name = "username"
			size = "20"
			maxlength = "50"/></td>
	</tr>

	<!-- Area to enter the password -->
	<tr>
		<td><font size="+2" face="arial"> Password  (Max 20 characters)</font size="+2"></td>
		<td
		align  = "left">
			<input type = "text"
			name = "password"
			size = "20"
			maxlength = "20"/></td>
	</tr>

	<!-- Area to enter the real name -->
	<tr>
		<td><font size="+2" face="arial"> Real Name  (Max 50 characters)</font size="+2"></td>
		<td
		align  = "left">
			<input type = "text"
			name = "nameOfUser"
			size = "20"
			maxlength = "50"/></td>
	</tr>
	
	<!-- Button to submit the information entered -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Add New User" /></td>
	</tr>
	</table>
	
	<font size="+2" face="arial" color="red"></br>Note: Please do not leave any of the above fields blank.</font>
	
		<!-- Redirects to the previous page -->
		</br></br><font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
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
		header("Location: login.php"); //Redirecting to login page
		die; //Terminating this page
	}
?>