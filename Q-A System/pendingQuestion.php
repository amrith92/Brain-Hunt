<?php

require_once('../common/include_session.php');

require_once ( '../common/include_validate login.php' );

?>

<?php

function pendingQuestion ( )
{
	global $_SESSION;
	global $dbh;
	
	$id = stripslashes ( htmlspecialchars ( $_SESSION['id'], ENT_QUOTES, 'UTF-8' ) );
	
	//$query = "SELECT * FROM `results` WHERE `user_ID`='".$_SESSION['id']."' AND `time_success` IS NULL HAVING `time_present` = MAX ( `time_present` );";
	$query = "SELECT * FROM `results` WHERE `user_ID`=:id AND `time_success` IS NULL ORDER BY `time_present` DESC LIMIT 1;";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":id", $id );
	$stmt->execute ( );

	$result = $stmt->fetch ( );
	
	if ( $result )
	{
		return $result['question_ID'];
	}
	else
	{
		return -1;
	}
}

?>
