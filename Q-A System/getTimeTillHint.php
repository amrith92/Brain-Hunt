<?php

require_once('../common/include_session.php');

require_once ( '../common/include_validate login.php' );

?>

<?php

function getTimeTillHint ( $qn )
{
	global $_SESSION;
	global $dbh;
	
	$ID = stripslashes ( htmlspecialchars ( $_SESSION['id'], ENT_QUOTES, 'UTF-8' ) );
	
	$query = "SELECT `time_present` FROM `results` WHERE `user_ID`=:id AND `time_success` IS NULL AND `question_ID`=:question ORDER BY `time_present` DESC LIMIT 1;";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":id", $ID );
	$stmt->bindParam ( ":question", $qn );
	$stmt->execute ( );
	$result = $stmt->fetch ( );
	
	$timestamp = strtotime ( $result['time_present'] );
	
	$timeDiff = time ( ) - $timestamp;
	
	return $timeDiff;
}

?>
