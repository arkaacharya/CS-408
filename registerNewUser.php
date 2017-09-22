<html>
<body>
<form>
	<?php
		$servername = "localhost"; //Name of server
		$dbname = "OnTheExamLine"; //Name of database
		$username = "root"; //Username used to connect to database
		$password = NULL; //Password used to connect to database
		
		$userName = $_POST['username']; //Getting the username
		echo $userName = preg_replace('/\s+/', '', $_POST['username']);
		
		$passWord = $_POST['password']; //Getting the password
		echo $passWord = preg_replace('/\s+/', '', $_POST['password']);
		
		$nameOfUser = $_POST['nameOfUser']; //Gettign the user's name
		
		$chapter = $_POST['chapter']; //Getting the chapter

		if ($userName == "" || $passWord == "" || $nameOfUser == "" ){
			
			header("Location: newUserInformation.php?acessor=admin"); //Redirecting to the next page
			die; //Terminating this page
		}
		
		$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to the database
		if($conn->error){ //Checking connection for errors
			die("Could not establish connection to database."); //Terminating this page
		}
		
		//Constructing an sql query to check if the user already exists
		$sql = "SELECT password FROM users WHERE username = \"".$userName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the query
		
		if($result){ //Checking if information was received
			header("Location: userAlreadyExists.php?acessor=admin"); //Redirecting to error page
			die; //Terminating this page
		}
		
		//Constructing an sql query to create a table for the user to store the chapters of the user
		$sql = "CREATE TABLE ".$userName."(flag INT UNSIGNED,
		chapter VARCHAR(600) PRIMARY KEY)";
		$data = mysqli_query($conn, $sql); //Executing the query
		
		//Constructing an sql query to insert the chapter name in the appropriate table
		$sql = "INSERT INTO ".$userName." (flag, chapter) VALUES (1, \"".$chapter."\")";
		$data = mysqli_query($conn, $sql); //Executing the query
		
		$flag = 1; //Initializing the flag
		//Constructing an sql query to get the next username in the table
		$sql = "SELECT username FROM users";
		$data = mysqli_query($conn, $sql); //Executing query
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
		while($result){ //Condition to loop as long as information is being received
			$flag++; //Incrementing flag
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
		}
		
		//Constructing an sql query to enter the user's information in the table
		$sql  = "INSERT INTO users (username, password, name, accessRest, flag) VALUES ('".$userName."', '".$passWord."', '".$nameOfUser."', 'user', ".$flag.")";
		$data = mysqli_query($conn, $sql); //Executing the query
		header("Location: newUserInformation.php?acessor=admin"); //Redirecting to the next page
		die; //Terminating this page
		
	?>
</form>
</body>
</html>