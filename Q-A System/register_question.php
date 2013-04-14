<?php

require_once('../common/include_session.php');

require_once ( '../common/include_validate login.php' );

?>

<?php

function register_question ( $qn )
{
	global $dbh;
	global $_SESSION;
	
	$user_id = $location = stripslashes ( htmlspecialchars ( $_SESSION['id'], ENT_QUOTES, 'UTF-8' ) );
	$question_id = $location = stripslashes ( htmlspecialchars ( $qn['ID'], ENT_QUOTES, 'UTF-8' ) );
	
	$query = "SELECT * FROM `results` WHERE `user_ID`=:user AND `question_ID`=:question;";
	$stmt = $dbh->prepare ( $query );
	$stmt->bindParam ( ":user", $user_id );
	$stmt->bindParam ( ":question", $question_id );
	$stmt->execute ( );
	$result = $stmt->fetch ( );
	
	if ( ! $result  )
	{
		$query = "INSERT INTO `results` ( `user_ID`, `question_ID` ) VALUES ( :user,:question );";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":user", $user_id );
		$stmt->bindParam ( ":question", $question_id );
		
		$stmt->execute ( );
	}
}

?>
