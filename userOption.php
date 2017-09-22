<?php
	$servername = "localhost"; //Name of server
	$dbname = "OnTheExamLine"; //Name of database
	$username = "root"; //Username used to connect to database
	$password = NULL; //Password used to connect to database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to database
	if($conn->error){ //Checking if connection has error
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
		die; //Terniminating this page
	}
	
	//Constructing an sql query to get the login value corresponding to the received username
	$sql = "SELECT isLoggedIn FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$isLoggedIn = $result[0]; //Storing the login value in another variable
	
	//constructing an sql query to get the name of the user from the apopropriate table
	$sql = "SELECT name FROM users WHERE username=\"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	$name = $result[0]; //Storing the name in another variable
	
	if($isLoggedIn){ //Checking the condition to display the webpage
?>
	<html>
	<head>
		<!-- Name on tab of page -->
		<title>User Page</title>
		

	<head>
	<body>
	<form
	action = ""
	method = "post">

		<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>User Page</h1></header></center>
	<header> <?php echo "Name: ".$name; ?>
	</br><?php echo "Username: ".$userName; ?></header></font>
	<div id="insideBody">
	
	<table border = "0">
	
	<!-- Options for the user displayed in a group of radio buttons -->
	<tr>
		<font size="+2" face="arial">Choose Action:</font size="+2">
		</br><input type = "radio" name = "userOpt" value = "testOption"/><font size="+2" face="arial">Take Test</font size="+2">
		</br><input type = "radio" name = "userOpt" value = "reviewGrades"/><font size="+2" face="arial">See Results</font size="+2">
	</tr>

	<!-- Button used to submit the selected option -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Submit" /></td>
	</tr>
	</table>
		<!-- Link used to logout -->
		<font size="+2" face="arial"><a href="logout.php?userName=<?php $userName = $_GET['userName'];echo $userName;?>">Logout</a></font size="+2">
	</div>
	</form>

	<?php
		if(isset($_POST['userOpt'])){ //Checking if an option has been selected
			header("Location: ".$_POST['userOpt'].".php?userName=".$userName); //Redirecting to the appropriate page
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
