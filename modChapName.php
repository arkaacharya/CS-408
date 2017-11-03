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
	<title>Select Chapter</title> <!-- Name on the tab of the webpage -->

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>
	
	<!-- Title of the webpage -->
	<font size="+2" face="arial"><center><header><h1>Select Chapter to be Changed</h1></header></center></font>

	<div id="insideBody">
	
	<table border = "0">

	<!-- Displaying the names of the chapters as radio buttons -->
	<tr>
		<font size="+2" face="arial">Select Chapter:</font>
		<?php
			$sql = "SELECT chapter FROM chapters"; //Constructing the sql query to get the name of a chapter
			$data = mysqli_query($conn, $sql); //Executing the sql query
			$result = mysqli_fetch_row($data); //Extracting information fro mthe executed query
			
			while(isset($result[0])){ //Condition for looping as long as there is information passed in the query
			?>
			<!-- Displaying the name of the chapter -->
			<font size="+2" face="arial"></br><input type = "radio" name = "chapter" value = "<?php echo $result[0]?>"/><?php echo $result[0]?></font>
		<?php
				$result = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		?>
	</tr>

	<!-- Button for submitting the selected chapter -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Select Chapter" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font>
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['chapter'])){ //Checking if the chapter has been set
				$chapter = $_POST['chapter']; //Getting the name of the selected chapter
				
				header("Location: newChapName.php?acessor=admin&chapter=".$_POST['chapter']); //Redirecting to the admin page
				die; //Terminating this page
			}
		?>
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