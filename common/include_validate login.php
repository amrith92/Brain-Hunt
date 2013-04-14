<?php

require_once ( 'include_session.php' );
require_once ( 'include_home.php' );

if ( $_SESSION['logged-in'] != true)
{
	session_destroy();
	header("Location: $HOME/Q-A System/login.php?error=2");
}

?>
