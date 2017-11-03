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
		$redirect = $_GET['redirect'];
?>
	<html>
	<head>
	<!-- Name on tab of page -->
	<title>Select User</title>

	</head>
	<body>
	<form
	action = ""
	method = "post"
	>

	<!-- Title of page -->
	<font size="+2" face="arial"><center><header><h1>Select User</h1></header></center></font>
	<div id="insideBody">

	<table border = "0">

	<!-- Displaying the usernames as a group of radio buttons -->
	<tr>
		<font size="+2" face="arial">Select Username:</font size="+2">
			<?php
				//Constructing an sql query to get the username
				$sql = "SELECT username FROM users";
				$data = mysqli_query($conn, $sql); //Executing the query
				$result = mysqli_fetch_row($data); //Extracting the infromation
				while($result){ //Condition to loop as long as information is being received
					if(($resultComp[0] == $result[1]) && ($result[0] != 'admin')){ //Checking if the username is a match and that it is not the admin
						if($redirect == "gradeTest"){
							$sql = "SELECT essayGraded FROM useranswers WHERE username=\"".$result[0]."\"";
							$data = mysqli_query($conn, $sql); //Executing the query
							$check = false;
							while($result1 = mysqli_fetch_row($data)){
								if($result1[0] == false){
									$check = true;
								}
							}
							if($check){
							?>
			<!-- Displaying the username -->
			</br><input type = "radio" name = "username" value = "<?php echo $result[0]?>"/><font size="+2" face="arial"><?php echo $result[0]?></font size="+2">
							<?php
							}
						}
						else{
				?>
			<!-- Displaying the username -->
			</br><input type = "radio" name = "username" value = "<?php echo $result[0]?>"/><font size="+2" face="arial"><?php echo $result[0]?></font size="+2">
			<?php
						}
					}
					$result = mysqli_fetch_row($data); //Extracting information from the executed query
				}
			?>
	</tr>

	<!-- Button used to submit the selected username -->
	<tr>
		<td
		colspan = "2"
		align  = "center">
			<input type = "submit"
			value = "Select User" /></td>
	</tr>
	</table>
		<!-- Redirecting to the previous page -->
		<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Back</a></font size="+2">
		</br></br>
	<font size="+2" face="arial"><a href="adminPage.php?acessor=admin">Home</a></font size="+2">
		</br></br>
		<font size="+2" face="arial"><a href="logout.php?userName=admin">Logout</a></font>

		<?php
			if(isset($_POST['username'])){ //Checking if a username has been selected
				$userName = $_POST['username']; //Getting the value of the selected username
				header("Location: selectTest.php?acessor=admin&userName=".$userName."&redirect=".$redirect); //Redirecting to the next page
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