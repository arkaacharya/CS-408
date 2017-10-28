<html>
<head>
<head>
<body>
<form>
	<?php
		$servername = "localhost"; //Name of server
		$dbname = "OnTheExamLine"; //Name of database
		$username = "root"; //Username used to connect to database
		$password = NULL; //Password used to connect to database
	
		$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to database
		if($conn->error){ //Checking connection for errors
			die("Could not establish connection to database."); //Terminating this webpage
		}
		
		$userName = $_POST['userName']; //Getting the username
		$testName = $_POST['testName']; //Getting the testname
		$totalEssayGrade = 0; //Initializing the variable
		$achievedEssayGrade = 0; //Initializing the variable
		$indivEssayGrade = array(); //Initializing the array
		$indivMaxGrade = array(); //Initializing the array
		
		$i = 1; //Used as a counter
		while(isset($_POST['essay'.$i.'Grade']) && isset($_POST['essay'.$i.'MaxGrade'])){ //Checking if the values passed have been set
			$totalEssayGrade += $_POST['essay'.$i.'MaxGrade']; //Incermenting totalEssayGrade
			$achievedEssayGrade += $_POST['essay'.$i.'Grade']; //Incrementing achievedEssayGrade
			$indivMaxGrade[$i] = $_POST['essay'.$i.'MaxGrade']; //Storing individual question's max grade
			$indivEssayGrade[$i] = $_POST['essay'.$i.'Grade']; //Storing individual question's achieved grade
			$i++; //Incrementing the counter
		}
		
		//Constructing an sql query to get the total correct MCQ and the final percentage
		$sql = "SELECT totalCorrect FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the query
		$totalMCQ = $result[0]; //Getting the MCQ grade
		
		$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = mysqli_fetch_row($data); //Extracting information from the query
		
		$maxMCQperc = (($result[0])/($result[0]+$result[1]))*100;
		$maxEssayPerc = 100 - $maxMCQperc;
		
		if($result[0] > 0){
			$finalMCQperc = ($totalMCQ/$result[0])*$maxMCQperc;
		}
		else{
			$finalMCQperc = 0;
		}
		
		if($totalEssayGrade > 0){
			$finalEssayPerc = ($achievedEssayGrade/$totalEssayGrade)*$maxEssayPerc;
		}
		else{
			$finalEssayPerc = 0;
		}
		
		
		$finalPercentage = $finalMCQperc + $finalEssayPerc; //Recalculating the final percentage
		
		//Constructing an sql query to update the grades of the user
		$sql = "UPDATE useranswers SET finalPercentage=".$finalPercentage.", totalEssayGrade=".$totalEssayGrade.", achievedEssayGrade=".$achievedEssayGrade.", essayGraded=1 WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the sql query
		
		$i = 1; //Used as a counter
		//Constructing an sql query to check if there is a column for each essay question's grade
		$sql = "SELECT essay".$i."grade, essay".$i."max FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
		$data = mysqli_query($conn, $sql); //Executing the query
		$result = false; //Initializing the variable
		
		if($data){ //Checking if the query executed properly
			$result = mysqli_fetch_row($data); //Extracting information from the executed query
		}
		
		while(isset($indivEssayGrade[$i])){ //Condition to loop as long as the questions have grades
			if($result){ //Checking if the query returned any information
				//Constructing an sql query to put the grade in the appropriate column in the appropriate table
				$sql = "UPDATE useranswers SET essay".$i."grade=".$indivEssayGrade[$i].", essay".$i."max=".$indivMaxGrade[$i]." WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
			}
			else{
				//Constructing an sql query to add a column for the grade achieved
				$sql = "ALTER TABLE useranswers ADD essay".$i."grade INT;";
				$data = mysqli_query($conn, $sql); //Executing the query
				
				//Constructing an sql query to add a column for the max grade
				$sql = "ALTER TABLE useranswers ADD essay".$i."max INT;"; 
				$data = mysqli_query($conn, $sql); //Executing the query
				
				//Constructing an sql query to put the grade in the appropriate column in the appropriate table
				$sql = "UPDATE useranswers SET essay".$i."grade=".$indivEssayGrade[$i].", essay".$i."max=".$indivMaxGrade[$i]." WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
				$data = mysqli_query($conn, $sql); //Executing the query
			}
			$i++; //Incrementing the counter
			//Constructing an sql query to check if there is a column for each essay question's grade
			$sql = "SELECT essay".$i."grade FROM useranswers WHERE username=\"".$userName."\" AND formNo=\"".$testName."\"";
			$data = mysqli_query($conn, $sql); //Executing the query
			$result = false; //Initializing the variable
			if($data){ //Checking if the query executer properly
				$result = mysqli_fetch_row($data); //Extracting information from the query
			}
		}
		
		header("Location: selectUser.php?acessor=admin&redirect=gradeTest"); //Redirecting to the next page
		die; //Termianting this page
	?>
</form>
</body>
</html>