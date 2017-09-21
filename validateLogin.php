<html>
<body>
<form>
	<?php
		$servername = "localhost"; //Name of server
		$dbname = "OnTheExamLine"; //Name of database
		$username = "root"; //Username used to connedt to database
		$password = NULL; //Password used to connect to database
		
		$userName = $_POST['username']; //Getting the user's username
		$passWord = $_POST['password']; //Getting the user's password
		$randKey = $_POST['randKey']; //Getting the value of the entered key
		$genKey = $_POST['genKey']; //Getting the value of the generated key
	
		$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to the database
		if($conn->error){ //Checking connection for errors
			die("Could not establish connection to database."); //Terminating this page
		}
		
		//Constructing an sql query to get the user information
		$sql = "SELECT password, accessRest FROM users WHERE username = \"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query

		if($data == false){ //Checking if the query was executed
			header("Location: errorLogin.php"); //Redirecting to the error page
			die; //Terminating this page
		}
		
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		
		
		if(($result[0] == $passWord)){ //Checking password
			if($userName == "admin"){ //checking if the username is admin
				$sql = "SELECT numLogin FROM users WHERE username=\"admin\"";
				$data = mysqli_query($conn, $sql);
				$result = mysqli_fetch_row($data);
				$result[0]++;
				//Constructing an sql query to indicate that the admin is logged in
				$sql = "UPDATE users SET isLoggedIn=1, numLogin=".$result[0]." WHERE username = \"".$userName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
				
				header("Location: adminPage.php?acessor=admin"); //Redirecting to the admin page
				die; //Terminating this page
			}
			else{
				$sql = "UPDATE users SET isLoggedIn=1 WHERE username = \"".$userName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
				
				header("Location: userOption.php?userName=".$userName); //Redirecting to the user page
				die; //Terminating this page
			}
		}
		else{
			header("Location: errorLogin.php"); //Redirecting to the error page
			die; //Terminating this page
		}
	?>
</form>
</body>
</html>