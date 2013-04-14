<?php

require_once('../common/include_session.php');

require_once ( '../common/include_validate login.php' );

session_destroy();

require_once('../common/include_home.php');

header("Location: " . $HOME);
exit();
