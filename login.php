<html>
<head>
	<!-- Name on tab of page -->
	<title>Login Page</title>
	
	<style>
		#tableContainer-1 {
			height: 80%;
			width: 100%;
			display: table;
			background-image: url("Pictures/loginPic.jpg?<?php echo time(); ?>");
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
		}
		#tableContainer-2 {
			vertical-align: middle;
			display: table-cell;
			height: 100%;
			background-image: url("Pictures/loginFront.jpg?<?php echo time(); ?>");
			background-repeat: no-repeat;
			background-position: center;
		}
		input { font-size: 18px; }
		select { font-size: 18px; }
	</style>
</head>
<body>
<form
action = "validateLogin.php"
method = "post">

<!-- Title of page -->
<font size="+2" face="arial"><center><header><h1>On The Exam Line</h1></header></center></font>

<div id="tableContainer-1" class="slide-image">
<div id="tableContainer-2">
<font size="+2" face="arial"><center><h2>Login</h2></center></font>

<table
	border = "0"
	align = "center"
>
<?php
	$servername = "localhost"; //Name of the server
	$dbname = "OnTheExamLine"; //Name of the database
	$username = "root"; //Username used to connect to the database
	$password = NULL; //Password used to connect to the database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to the database
	if($conn->error){ //Checking connection for errors
		die("Could not establish connection to database."); //Terminating the page
	}
?>

<!-- Area for user to enter the username -->
<tr>
	<td><font size="+2" face="arial">Username:</font></td>
	<td
	align  = "center">
		<input type = "text"
		name = "username"
		size = "20"
		maxlength = "50"
		/></td>
</tr>

<!-- Area for user to enter password -->
<tr>
	<td><font size="+2" face="arial">Password:</font></td>
	<td
	align  = "left">
		<input type = "password"
		name = "password"
		size = "20"
		maxlength = "20"/></td>
</tr>


<!-- Button to turn in information for validation -->
<tr>
	<td
	colspan = "2"
	align  = "center">
		<input type = "submit"
		value = "Login" /></td>
</tr>
</table>
</div>
</div>
</form>

</body>
</html>