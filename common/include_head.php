<?php

require_once ( 'include_home.php' );

$HEAD = "
<div class=\"head\">
	
	<div class=\"greeter\">
		Hey, <b>" . $_SESSION['name'] . "</b>!
	</div>
	
	<div class=\"home\">
		<a href=\"$HOME/Q-A System/profile.php\">Home</a>
	</div>
	
	<div class=\"logout\">
		<a href=\"$HOME/Q-A System/logout.php\">Log Out</a>
	</div>
	
</div>


<br><hr><br>
";

?>
