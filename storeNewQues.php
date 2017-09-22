<?php
	$servername = "localhost"; //Name of server
	$dbname = "OnTheExamLine"; //Name of database
	$username = "root"; //Username used to connect to database
	$password = NULL; //Password used to connect to database

	$conn = new mysqli($servername, $username, $password, $dbname); //Establishing connection to databace
	if($conn->error){ //Checking the connection for errors
		die("Could not establish connection to database."); //Terminating this page
	}
	
	$testName = $_POST['testName']; //Getting the value of the test name

	//Constructing an sql query to get the number of MCQ and essay questions
	$sql = "SELECT numMCQ, numEssay FROM form WHERE formNo = \"".$testName."\"";
	$data = mysqli_query($conn, $sql); //Executing the sql query
	$result = mysqli_fetch_row($data); //Extracting the information from the executed query
	$numMCQ = $result[0]; //Storing the number of MCQ
	$numEssay = $result[1]; //Storing the number of essay questions

	$check = false;

	for($i = 1; $i <= $numMCQ; $i++){ //Loop to store new questions
		//Constructing an sql query to get the question number and to check if it is an MCQ question or not
		$sql = "SELECT quesNum, isMCQ, isEssay FROM ".$testName." WHERE quesNum = \"".$i."\"";
		$data = mysqli_query($conn, $sql); //Executing query
		$result = mysqli_fetch_row($data); //Extracting information from the query
		
		if($result){ //Checking if information was received
			
			if($_POST['ques'.$i] != ""){
				//Constructing an sql query to store the new question
				$sql = "UPDATE ".$testName." SET question=\"".$_POST['ques'.$i]."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}

			if($_POST['opt'.$i.'a'] != ""){
				//Constructing an sql query to store the new option
				$sql = "UPDATE ".$testName." SET opta=\"".$_POST['opt'.$i.'a']."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}

			if($_POST['opt'.$i.'b'] != ""){
				//Constructing an sql query to store the new option
				$sql = "UPDATE ".$testName." SET optb=\"".$_POST['opt'.$i.'b']."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}

			if($_POST['opt'.$i.'c'] != ""){
				//Constructing an sql query to store the new option
				$sql = "UPDATE ".$testName." SET optc=\"".$_POST['opt'.$i.'c']."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}

			if($_POST['opt'.$i.'d'] != ""){
				//Constructing an sql query to store the new option
				$sql = "UPDATE ".$testName." SET optd=\"".$_POST['opt'.$i.'d']."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}

			if($_POST['ans'.$i] != ""){
				//Constructing an sql query to store the new answer
				$sql = "UPDATE ".$testName." SET corrAns=\"".$_POST['ans'.$i]."\" WHERE quesNum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['ques'.$i.'img'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET questionImage=true WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET questionImage=false WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['ques'.$i.'optaimg'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET optaImage=true WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET optaImage=false WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['ques'.$i.'optbimg'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET optbImage=true WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET optbImage=false WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['ques'.$i.'optcimg'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET optcImage=true WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET optcImage=false WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['ques'.$i.'optdimg'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET optdImage=true WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET optdImage=false WHERE quesnum=".$i;
				$data = mysqli_query($conn, $sql); //Executing query
			}
		}
		else{
			if($_POST['ques'.$i] != "" && $_POST['opt'.$i.'a'] != "" && $_POST['opt'.$i.'b'] != "" && $_POST['opt'.$i.'c'] != "" && $_POST['opt'.$i.'d'] != "" && $_POST['ans'.$i] != ""){
				//Constructing an sql query to insert the new question and options into the database
				$sql = "INSERT INTO ".$testName." (quesnum, question, isMCQ, isEssay, opta, optb, optc, optd, corrAns) VALUES (".$i.",\"".$_POST['ques'.$i]."\",true,false,\"".$_POST['opt'.$i.'a']."\",\"".$_POST['opt'.$i.'b']."\",\"".$_POST['opt'.$i.'c']."\",\"".$_POST['opt'.$i.'d']."\",\"".$_POST['ans'.$i]."\")";
				$data = mysqli_query($conn, $sql); //Executing query
				
				if(isset($_POST['ques'.$i.'img'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET questionImage=true WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET questionImage=false WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				
				if(isset($_POST['ques'.$i.'optaimg'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET optaImage=true WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET optaImage=false WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				
				if(isset($_POST['ques'.$i.'optbimg'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET optbImage=true WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET optbImage=false WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				
				if(isset($_POST['ques'.$i.'optcimg'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET optcImage=true WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET optcImage=false WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				
				if(isset($_POST['ques'.$i.'optdimg'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET optdImage=true WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET optdImage=false WHERE quesnum=".$i;
					$data = mysqli_query($conn, $sql); //Executing query
				}
			}
		}
	}

	for($i = 1; $i <= $numEssay; $i++){ //Loop to ass new essay questions
		//Constructing an sql query to check if a question exists in that spot
		$sql = "SELECT quesNum, isMCQ, isEssay FROM ".$testName." WHERE quesNum = \"".($i+$numMCQ)."\"";
		$data = mysqli_query($conn, $sql); //Executing query
		$result = mysqli_fetch_row($data); //Extracting information from executed query
		
		if($result){ //Checking if any information was received
		
			if($_POST['quesEssay'.$i] != ""){
				//Constructing an sql query to store the new question
				$sql = "UPDATE ".$testName." SET question=\"".$_POST['quesEssay'.$i]."\" WHERE quesNum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if($_POST['ansEssay'.$i] != ""){
				$sql = "UPDATE ".$testName." SET ansEssay=\"".$_POST['ansEssay'.$i]."\" WHERE quesNum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			if(isset($_POST['essayques'.$i.'img'])){ //Checking if image option is checked
				//Constructing an sql query to indicate image is present
				$sql = "UPDATE ".$testName." SET questionImage=true WHERE quesnum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql); //Executing query
			}
			else{
				//Constructing an sql query to indicate image is not present
				$sql = "UPDATE ".$testName." SET questionImage=false WHERE quesnum=".($i+$numMCQ);
				$data = mysqli_query($conn, $sql); //Executing query
			}
			
			//Constructing an sql query to indicate that this is an essay question
			$sql = "UPDATE ".$testName." SET isMCQ=false WHERE quesNum=".($i+$numMCQ);
			$data = mysqli_query($conn, $sql); //Executing query
			
			//Constructing an sql query to indicate that this not an MCQ
			$sql = "UPDATE ".$testName." SET isEssay=true WHERE quesNum=".($i+$numMCQ);
			$data = mysqli_query($conn, $sql); //Executing query
		}
		else{
			if($_POST['quesEssay'.$i] != "" && $_POST['ansEssay'.$i] != ""){
				//Constructing an sql query to insert the new question into the database
				$sql = "INSERT INTO ".$testName." (quesnum, question, isMCQ, isEssay, ansEssay) VALUES (\"".($i+$numMCQ)."\",\"".$_POST['quesEssay'.$i]."\", false, true, \"".$_POST['ansEssay'.$i]."\")";
				$data = mysqli_query($conn, $sql); //Executing query
				
				if(isset($_POST['essayques'.$i.'img'])){ //Checking if image option is checked
					//Constructing an sql query to indicate image is present
					$sql = "UPDATE ".$testName." SET questionImage=true WHERE quesnum=".($i+$numMCQ);
					$data = mysqli_query($conn, $sql); //Executing query
				}
				else{
					//Constructing an sql query to indicate image is not present
					$sql = "UPDATE ".$testName." SET questionImage=false WHERE quesnum=".($i+$numMCQ);
					$data = mysqli_query($conn, $sql); //Executing query
				}
				
			}
		}
	}

	$check = true; //Initializing check
	for($i = 1; $i <= $numMCQ; $i++){ //Loop to check if all the questions have been entered
		if($_POST['ques'.$i] == "" || $_POST['opt'.$i.'a'] == "" || $_POST['opt'.$i.'b'] == "" || $_POST['opt'.$i.'c'] == "" || $_POST['opt'.$i.'d'] == "" || $_POST['ans'.$i] == ""){
			$check = false; //Changing check value
		}
	}
	for($i = 1; $i <= $numEssay; $i++){ //Loop to check if all the questions have been entered
		if($_POST['quesEssay'.$i] == "" || $_POST['ansEssay'.$i] == ""){
			$check = false; //Changing check value
		}
	}
	
	if(!$check){
		header("Location: modQues.php?acessor=admin&testName=".$testName);
		die;
	}
	else{
		header("Location: modOptTest.php?acessor=admin&testName=".$testName); //Redirecting to the next page
		die;
	}
?>
</table>
</form>
</body>
</html>