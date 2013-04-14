<?php

require_once ( '../common/include_database.php' );
require_once ( '../common/include_home.php' );


if ( ! preg_match ( "/^[A-Za-z0-9_.]+@vit.ac.in$/", $_POST['email1'] ) || ! preg_match ( "/^[A-Za-z0-9_.]+@vit.ac.in$/", $_POST['email2'] ) )
{
	echo "<script>alert(\"VIT Email Address Only!\");";
	echo "window.location.href=\"signup.html.php\";</script>";
	
	exit();
}

$query = "SELECT COUNT(*) FROM `user_auth` WHERE `username`=:username;";
$stmt = $dbh->prepare ( $query );
$username = stripslashes ( htmlspecialchars ( $_POST['username'], ENT_QUOTES, 'UTF-8' ) );
$stmt->bindParam(":username", $username);
$stmt->execute ( );
$result = $stmt->fetch ( );

$query = "SELECT COUNT(*) FROM `user_data` WHERE ( `email1`=:email1 AND `verified1`='1' ) OR ( `email2`=:email1 AND `verified2`='1' );";
$stmt = $dbh->prepare ( $query );
$email1 = stripslashes ( htmlspecialchars ( $_POST['email1'], ENT_QUOTES, 'UTF-8' ) );
$stmt->bindParam(":email1", $email1);
$stmt->execute ( );
$result2 = $stmt->fetch ( );

$query = "SELECT COUNT(*) FROM `user_data` WHERE ( `email1`=:email2 AND `verified1`='1' ) OR ( `email2`=:email2 AND `verified2`='1' );";
$stmt = $dbh->prepare ( $query );
$email2 = stripslashes ( htmlspecialchars ( $_POST['email2'], ENT_QUOTES, 'UTF-8' ) );
$stmt->bindParam(":email2", $email2);
$stmt->execute ( );
$result3 = $stmt->fetch ( );

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
	<title>Brain Hunt | Register | InFOSSphere | VITC</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

	<div class="container white rounded padded">
		<div class="row">
			<div class="span12">
				<h1>Registration Report</h1>
			</div>
		</div>
		<div class="row">
			<div class="span12">
<?php

if ( $result[0] == 0 )
{
	if ( $result2[0] == 0 && $result3[0] == 0 )
	{
		$username = stripslashes ( htmlspecialchars ( $_POST['username'], ENT_QUOTES, 'UTF-8' ) );
		$pass = md5 ( $_POST['password'] );
	
		$query = "INSERT INTO `user_auth` ( `username`, `password` ) VALUES ( :username, :pass );";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":username", $username );
		$stmt->bindParam ( ":pass", $pass );
	
		$stmt->execute ( );
	
		$ID = $dbh->lastInsertId();
	
		$name1 = stripslashes ( htmlspecialchars ( $_POST['name1'], ENT_QUOTES, 'UTF-8' ) );
		$email1 = stripslashes ( htmlspecialchars ( $_POST['email1'], ENT_QUOTES, 'UTF-8' ) );
		$name2 = stripslashes ( htmlspecialchars ( $_POST['name2'], ENT_QUOTES, 'UTF-8' ) );
		$email2 = stripslashes ( htmlspecialchars ( $_POST['email2'], ENT_QUOTES, 'UTF-8' ) );
		
		$code1 = randomStr();
		$code2 = randomStr();
		
		sendMail ( $ID, $code1, $_POST['email1'], $_POST['name1'] );
		sendMail ( $ID, $code2, $_POST['email2'], $_POST['name2'] );

		$query = "INSERT INTO `user_data` ( `ID`, `name1`, `email1`, `code1`, `verified1`, `name2`, `email2`,`code2`, `verified2` ) VALUES ( :id, :name1, :email1, :code1, '0', :name2, :email2, :code2, '0' );";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":id", $ID );
		$stmt->bindParam ( ":name1", $name1 );
		$stmt->bindParam ( ":email1", $email1 );
		$stmt->bindParam ( ":name2", $name2 );
		$stmt->bindParam ( ":email2", $email2 );
		$stmt->bindParam ( ":code1", $code1 );
		$stmt->bindParam ( ":code2", $code2 );
		$stmt->execute ( );
		
		echo "<div class=\"biggish\">Everything seems to be proceeding normally!<br><br>Please check your Spam too!</div>";
	}
	else
	{
		echo "<div class=\"biggish\">One of the given email's is already verified with some other team!</div>";
	}
}
else
{
	echo "<div class=\"biggish\">Team Name Taken :(</div>";
}

?>

<?php

function randomStr() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = mt_rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function sendMail ( $ID, $code, $email, $name )
{
global $HOME;

$path = get_include_path() . PATH_SEPARATOR . '/home/vitvi8pm/php'. PATH_SEPARATOR . '/usr/share/php';
set_include_path($path);

require_once "Mail.php";

$from = "\"VIT Chennai GLUG\" <vitcclug@vit.ac.in>";
$to = "<$email>";
$subject = "Email Conformation for Brain Hunt!";
$body = "Dear $name,\nPlease click on the following link o confirm your account to Brain Hunt\n\n$HOME/Q-A%20System/verify.php?email=$email&code=$code&ID=$ID";

$host = "ssl://smtp.gmail.com";
$port = "465";
$username = "vitcclug@vit.ac.in";  //<> give errors
$password = "2010@Linux#";

$headers = array ('From' => $from,
'To' => $to,
'Subject' => $subject);
$smtp = Mail::factory('smtp',
array ('host' => $host,
'port' => $port,
'auth' => true,
'username' => $username,
'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
echo("<p>" . $mail->getMessage() . "</p>");
} else {
echo("<div class=\"biggish\">Dear $name, Go to your inbox and confirm email!</div>");
}
}

?>
			</div>
		</div>
	</div>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
