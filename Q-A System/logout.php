<?php

require_once('../common/include_session.php');

session_destroy();

require_once('../common/include_home.php');

?> 

<!DOCTYPE html>

<html>

<head>
	<title>Log Out</title>
</head>

<body>

	Logout Success!
	<br>
	<a href="<?php echo $HOME; ?>/Q-A System/login.php">Go To Login Page</a>

</body>

</html>
