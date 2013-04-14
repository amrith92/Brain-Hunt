<?php

require_once ( '../common/include_session.php' );

require_once ( '../common/include_validate login.php' );

require_once ( '../common/include_head.php' );

require_once ( '../common/include_database.php' );

require_once ( 'pendingQuestion.php' );

require_once ( 'getTimeTillHint.php' );

$hintTimeout = 900;

$qn = pendingQuestion ( );

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8" />
	<title>Reporting</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="centered">
<?php
$__points = 0;
$__is_right = false;
if ( $qn >= 0 )
{

	$status = checkAns ( $qn, $_POST['ans'] );

	$id = stripslashes ( htmlspecialchars ( $_SESSION['id'], ENT_QUOTES, 'UTF-8' ) );
	$qn = stripslashes ( htmlspecialchars ( $qn, ENT_QUOTES, 'UTF-8' ) );
	$ans = stripslashes ( htmlspecialchars ( $_POST['ans'], ENT_QUOTES, 'UTF-8' ) );
	$status = stripslashes ( htmlspecialchars ( $status, ENT_QUOTES, 'UTF-8' ) );

	$query = "INSERT INTO `attempts` ( `user_ID`, `question_ID`, `answer`, `result` ) VALUES ( :id, :qn, :ans, :status );";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":id", $id );
	$stmt->bindParam ( ":qn", $qn );
	$stmt->bindParam ( ":ans", $ans );
	$stmt->bindParam ( ":status", $status );
	$stmt->execute ( );

	if ( $status == true )
	{
		$timeDiff = getTimeTillHint ( $qn );
		
		if ( $timeDiff > $hintTimeout )
		{	
			$query = "UPDATE `results` SET `time_success`=now(), `hint`='1' WHERE `user_ID`=:id AND `question_ID`=:qn;";
		}
		else
		{
			$query = "UPDATE `results` SET `time_success`=now(), `hint`='0' WHERE `user_ID`=:id AND `question_ID`=:qn;";
		}
		
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":id", $id );
		$stmt->bindParam ( ":qn", $qn );
		$stmt->execute ( );
	
		if ( $timeDiff > $hintTimeout )
		{	
			$query = "UPDATE `user_state` SET `points`=`points`+20 WHERE `user_ID`=:id;";
		}
		else
		{
			$query = "UPDATE `user_state` SET `points`=`points`+40 WHERE `user_ID`=:id;";
		}
	
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":id", $id );
		$stmt->execute ( );
	
		$query = "SELECT `level`, `points` FROM `user_state` WHERE `user_ID`=:id;";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":id", $id );
		$stmt->execute ( );
		$result = $stmt->fetch ( );
		$currLevel = stripslashes ( htmlspecialchars ( $result['level'], ENT_QUOTES, 'UTF-8' ) );
		$currPoints = $result['points'];
		$__points = $result['points'];
	
		$query = "SELECT `threshold` FROM `thresholds` WHERE `level`=:currLevel;";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":currLevel", $currLevel );
		$stmt->execute ( );
		$result = $stmt->fetch ( );
		$threshold = $result['threshold'];
	
		if ( $currPoints >= $threshold )
		{
			$query = "UPDATE `user_state` SET `level`=`level`+1 WHERE `user_ID`=:id;";
			$stmt = $dbh->prepare ( $query );
			$stmt->bindParam ( ":id", $id );
			$stmt->execute ( );
		}

		$__is_right = true;
		echo "<p><strong>Right!</strong></p>";
	}
	else
	{
		echo "</p><strong>Wrong!</strong></p>";
	}
}

?>

		<p>
			Hurrah! You've answered this question! Your score is:
		</p>
		<div class="score big">
			<?php echo $__points; ?>
		</div>

		<div>

<?php

echo "<br><a href=\"question.php\" class=\"big\">Continue &raquo;</a>";

?>
		</div>

<?php

function checkAns ( $qn, $ans )
{
	global $dbh;
	
	$query = "SELECT `answer` FROM `questions` WHERE `ID`='$qn';";
	$stmt = $dbh->prepare ( $query );
	$stmt->execute ( );
	
	$result = $stmt->fetch();
	
	$correctAns = $result['answer'];
	
	if ( preg_match ( "/\b\d*[!@#$%^&*()+-_=]*" . strtolower ( $correctAns ) . "\b\d*[!@#$%^&*()+-_=]*/", strtolower ( $ans ) ) )
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>
			</div>
		</div>
	</div>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/cookiemanager.js"></script>
	<script type="text/javascript" src="js/ajaxresponder.js"></script>
	<script src="js/locations.js"></script>
	<script type="text/javascript">
//<!--
	window.onload = function() {
		var ___ = <?php if ($__is_right) echo 'true'; else echo 'false'; ?>;
		locInit();
		if (___)
			locStore();
	}
//-->
	</script>
</body>
</html>
