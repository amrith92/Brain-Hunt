<?php

require_once('../common/include_session.php');

require_once ( '../common/include_validate login.php' );

require_once ( '../common/include_database.php' );

if ( $_SESSION['id'] >= 0 )
{
	echo "<script>alert('Invalid Page');";
	echo "window.location.href = 'question.php';</script>";
}

?>

<?php

if ( isset ( $_POST['upload'] ) )
{
	move_uploaded_file ( $_FILES['qn']['tmp_name'], "../Questions/".$_FILES['qn']['name'] );
	$location = "/Questions/".$_FILES['qn']['name'];
	$location = stripslashes ( htmlspecialchars ( $location, ENT_QUOTES, 'UTF-8' ) );
	
	$answer = $_POST['ans'];
	$answer = stripslashes ( htmlspecialchars ( $answer, ENT_QUOTES, 'UTF-8' ) );
	
	$hint = $_POST['hint'];
	$hint = $location = stripslashes ( htmlspecialchars ( $hint, ENT_QUOTES, 'UTF-8' ) );
	
	$level = $_POST['level'];
	$level = stripslashes ( htmlspecialchars ( $level, ENT_QUOTES, 'UTF-8' ) );
	
	$id = $location = stripslashes ( htmlspecialchars ( $_SESSION['id'], ENT_QUOTES, 'UTF-8' ) );
	
	$query = "INSERT INTO `questions` ( `location`, `answer`, `hint`, `level`, `uploader` ) VALUES ( :location, :answer, :hint, :level, :uploader );";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":location", $location );
	$stmt->bindParam ( ":answer", $answer );
	$stmt->bindParam ( ":hint", $hint );
	$stmt->bindParam ( ":level", $level );
	$stmt->bindParam ( ":uploader", $id );
	$stmt->execute ( );
	
	
	echo "<script>alert('Question Recorded Successfully!');";
	echo "window.location.href = 'question_upload.php';</script>";
}

?>

<form method="post" enctype="multipart/form-data">
	Question Picture File : <input type="file" name="qn"><br>
	Answer : <input name="ans"><br>
	Hint : <input name="hint"><br>
	Level of Difficulty : <select name="level">
		<option value="0">Easy</option>
		<option value="1">Medium</option>
		<option value="2">Hard</option>
	</select><br>
	<input type="submit">
	<input type="hidden" name="upload">
</form>

<a href="logout.php">Log Out</a>
