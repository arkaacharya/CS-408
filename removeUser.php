<?php
$servername = "localhost"; //Name of the server
$dbname = "OnTheExamLine"; //Name of the database
$username = "root"; //Username used to connect to the database
$password = NULL; //Password used to connect to the database

$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
if($conn->error){ //Checking connection for errors
	die("Could not establish connection to database."); //Terminating this page
}

if(isset($_POST['username'])){
	$userName = $_POST['username']; //Gettin gthe value of the selected username
}
else{
	$userName = $_GET['username']; //Gettin gthe value of the selected username
}

//Creating an sql query to check whether the username exists
$sql = "SELECT * FROM users WHERE username = \"".$userName."\"";
$data = mysqli_query($conn, $sql); //Executing the sql query
$result = mysqli_fetch_row($data); //Extracting information from the executed query

if(!$result){ //Checking if information was received
	header("Location: userDoesntExist.php?acessor=admin"); //Redirecting to the error page
	die; //Terminating this page
}
else{
	
	//Creating an sql query to delete the table corresponding to the selected username
	$sql = "DROP TABLE ".$userName;
	$data = mysqli_query($conn, $sql); //Executing the sql query
	
	//Creating an sql query to get the falg value corresponding the the selected username
	$sql = "SELECT flag FROM users WHERE username = \"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$flag1 = mysqli_fetch_row($data); //Extracting information from the executed query
	
	//Creating an sql query to delete the selected user from the database
	$sql = "DELETE FROM users WHERE username = \"".$userName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	
	//Creating an sql query to check if there is a next flag value
	$sql = "SELECT flag FROM users WHERE flag = \"".($flag1[0]+1)."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$flag = mysqli_fetch_row($data); //Extracting the next flag value

	while($flag){
		//Creating an sql query to update the flag value of the remaining users
		$sql = "UPDATE users SET flag=".$flag1[0]." WHERE flag = \"".($flag1[0]+1)."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql value
		
		$flag1[0]++; //Incrementing the falg value
		
		//Creating an sql query to check if there is a next flag value
		$sql = "SELECT flag FROM users WHERE flag = \"".($flag1[0]+1)."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		$flag = mysqli_fetch_row($data); //Extracting the next flag value
	}
	
	/**$i = 1; //Used as a counter
	//Constructing an sql query to get the username from the answers table
	$sql = "SELECT username FROM useranswers";
	$data1 = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data1); //Extracting the information from the executed query
	while($result){ //Condition to loop as long as information is received
		if($result[0] == $userName){ //Checking if the username is a match
			$j = $i; //Initializing a new counter
			//Constructing an sql query to remove the entry corresponding to this user
			$sql = "DELETE FROM useranswers WHERE SrNo = \"".$j."\"";
			$data = mysqli_query($conn, $sql); //Executing the sql query
			
			//Constructing an sql query to check if there are any other entries after this one
			$sql = "SELECT SrNo FROM useranswers WHERE SrNo = ".($j+1)."";
			$data = mysqli_query($conn, $sql); //Executing the corresponding query
			$flag = mysqli_fetch_row($data); //Extracting information from the executed query

			while($flag){
				//Constructing an sql query to update the SrNo of the remaining entries
				$sql = "UPDATE useranswers SET SrNo=".$j." WHERE SrNo = \"".($j+1)."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				
				$j++; //Incermenting the counter
				
				//Constructing an sql query to check if there are any other entries after this one
				$sql = "SELECT SrNo FROM useranswers WHERE SrNo = \"".($j+1)."\"";
				$data = mysqli_query($conn, $sql); //Executing the sql query
				$flag = mysqli_fetch_row($data); //Extracting information from the executed query
			}
		}
		$result = mysqli_fetch_row($data1); //Extracting information from the executed query
	}*/
	
	if(isset($_GET['redirect'])){

	}
	else{
		header("Location: delUser.php?acessor=admin"); //Redirecting to the next page
		die; //Terminating this page
	}
}
?>