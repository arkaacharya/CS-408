<?php
	$userName = $_GET['userName']; //Getting the username
?>
	<html>
	<head>
		<!-- Name on tab of page -->
		<title>Not Eligible for Test</title>
		
		<!-- Redirecting after timer -->
		<meta http-equiv="refresh" content= "2; url='userOption.php?userName=<?php echo $userName ?>'"/>
	<head>
	<body>
	<form>
		<!-- Displaying error message -->
		<center><header><font size="+2" face="arial"><h1>You are not eligible to take this exam.</h1></font></header></center>
	</form>

	</body>
	</html>
<?php
?>