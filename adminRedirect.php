<?php

if($_POST['adminOpt'] == "addUser"){ //Checking the value of the choice made by the admin
	header("Location: newUserInformation.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "modUser"){ //Checking the value of the choice made by the admin
	header("Location: modUser.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "delUser"){ //Checking the value of the choice made by the admin
	header("Location: delUser.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "newTest"){ //Checking the value of the choice made by the admin
	header("Location: newTest.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "modTest"){ //Checking the value of the choice made by the admin
	header("Location: modTest.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "delTest"){ //Checking the value of the choice made by the admin
	header("Location: delTest.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "reviewPerformance"){ //Checking the value of the choice made by the admin
	header("Location: revPerf.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "addChap"){ //Checking the value of the choice made by the admin
	header("Location: addChap.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "cloneTest"){ //Checking the value of the choice made by the admin
	header("Location: cloneTest.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "modChapName"){ //Checking the value of the choice made by the admin
	header("Location: modChapName.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "reviewAns"){ //Checking the value of the choice made by the admin
	header("Location: selectUser.php?acessor=admin&redirect=reviewAns"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else if($_POST['adminOpt'] == "reviewStats"){ //Checking the value of the choice made by the admin
	header("Location: reviewTest.php?acessor=admin"); //Redirecting to the appropriate page
	die; //Terminating this page
}
else{
	header("Location: selectUser.php?acessor=admin&redirect=gradeTest"); //Redirecting to the appropriate page
	die; //Terminating this page
}

?>