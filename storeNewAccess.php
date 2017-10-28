<?php
$servername = "localhost"; //Name of the server
$dbname = "OnTheExamLine"; //Name of the database
$username = "root"; //Username used to connect to the database
$password = NULL; //Password used to connect to the database

$conn = new mysqli($servername, $username, $password, $dbname); //Connecting to the database
if($conn->error){ //Checking connection for errors
	die("Could not establish connection to database."); //Terminating this page
}

$accessName = $_POST['accessName']; //Extracting the entered accessName
$accessName = preg_replace('/\s+/', '', $accessName);

if($accessName == ""){
	header("Location: addAccess.php?acessor=admin"); //Redirecting to the next page
	die; //Terminating this page
}
//Creating an sql statement to check if the access type already exists
$sql = "SELECT * FROM access WHERE accessType = \"".$accessName."\"";
$data = mysqli_query($conn, $sql); //Executing the sql query
$result = mysqli_fetch_row($data); //Extracting the data from executed query

if($result == true){ //Checking if any data was given
	header("Location: accessAlreadyExists.php?acessor=admin"); //Redirecting to error page
	die; //Terminating this page
}
else{
	$flag = 1; //Used as counter
	//Creating an sql statement to get the next access type
	$sql = "SELECT accessType FROM access";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting information from the executed query
	while($result){ //Condition used for looping as long as information is being returned
		$flag++; //Incrementing the counter
		$result = mysqli_fetch_row($data); //Extracting information from the executed query
	}
	//Creating an sql statement to add the next access type
	$sql = "INSERT INTO access (accessType, flag) VALUES (\"".$accessName."\",".$flag.")";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	header("Location: addAccess.php?acessor=admin&userName=admin"); //Redirecting to the next page
	die; //Terminating this page
}
?>