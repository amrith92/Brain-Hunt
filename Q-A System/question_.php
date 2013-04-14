<?php

require_once ( '../common/include_session.php' );

require_once ( '../common/include_validate login.php' );

require_once ( '../common/include_head.php' );

require_once ( '../common/include_database.php' );

require_once ( '../common/include_home.php' );

?>

<?php

require_once ( 'next_question.php' );

require_once ( 'register_question.php' );

require_once ( 'getTimeTillHint.php' );

$hintTimeout = 30;

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>GLUG: BRAIN-HUNT | Your Profile</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script type="text/javascript" src="js/cookiemanager.js"></script>
	<script type="text/javascript" src="js/locations.js"></script>
	<script type="text/javascript">
//<!--
	window.onload = function() {
		locInit();
		var i = document.getElementById('loc-img');
		var t = document.getElementById('loc-txt');
		if ( i != null) {
			i.innerHTML = '<img src="' + Locations[_idx].getPath() + '" class="img-circle">';
		}
		if (t != null) {
			t.innerHTML = Locations[_idx].getName();
		}
	}
//-->
	</script>
</head>

<body>
	
	<?php echo $HEAD; ?>
	
	<?php
	
	$qn = next_question ( );
	
	setcookie ( '__cq', $qn['ID']);
	
	if ( $qn < 0 )
	{
		echo "$qn\n<script>alert ( \"End of Questions!\\nYou will now be logged out\" );\n";
		echo "window.location.href = \"logout.php\";</script>";
		exit ( );
	}
	
	register_question ( $qn );
	
	?>
	
	<?php
	
	echo "<script>\n";
	
	if ( ( $timeDiff = getTimeTillHint ( $qn['ID'] ) ) < $hintTimeout )
	{
		$str = <<<MARK
var timeDiff = {$timeDiff};
var flag = setInterval ( timer, 1000 );

function timer ( )
{
	var minutes, seconds;

	timeDiff ++;

	if ( timeDiff < {$hintTimeout} )
	{
		minutes = parseInt ( ( {$hintTimeout} - timeDiff ) / 60 );
		seconds = ( {$hintTimeout} - timeDiff ) % 60;
		document.getElementById ( 'timeLeft' ).innerHTML = "The hint will be available in -> ";
		document.getElementById ( 'timeLeft' ).innerHTML += minutes + " : " + seconds;
	}
	else
	{
		document.getElementById ( 'timeLeft' ).innerHTML = "<b><i>The <u>Hint</u> for This question is now available.</i><br>Refresh to View</b>";
		clearInterval(flag);
	}
}
MARK;
		echo $str;
		
	}
	else
	{
		$id = stripslashes ( htmlspecialchars ( $qn['ID'], ENT_QUOTES, 'UTF-8' ) );
		$query = "SELECT `hint` FROM `questions` WHERE `ID`=:id;";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":id", $id );
		$stmt->execute ( );
		$result = $stmt->fetch ( );
		
		$hint = $result[0];
		
		echo "var int=setTimeout ( function(){ document.getElementById ( 'timeLeft' ).innerHTML=\"<strong>". $hint ."</strong>\";}, 1000 );\n";
	}
	
	echo "</script>";
	
	?>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span5">
				<div class="centered">
					<div id="loc-img">

					</div>
					<br />
					<div id="loc-txt">

					</div>
					<h3>
						You are HERE^!
					</h3>
					<p>
						Answer the question to explore further! We have a WHOLE bunch of <strong>AWESOME</strong> shit in store!
					</p>
					<div class="right big">
						&rarr;
					</div>
				</div>
			</div>
			<div class="span7">
				<div class="centered">
					<img src="<?php echo $HOME.$qn['location']; ?>" title="Treasure?" class="img-polaroid">
				</div>
			</div>
		</div>

		<div class="row-fluid" style="margin-top: 20px;">
			<div class="span5">

			</div>

			<div class="span7">
				<form action="submit_question.php" method="post" class="centered">
					<div class="input-append">
						<input type="text" name="ans">
						<button type="submit" class="btn">Answer!</button>
					</div>
				</form>
			</div>
		</div>
	
		<script>
		function hintToggle ( )
		{
			if ( document.getElementById ( 'hintButton' ).value == "Show Hint" )
			{
				document.getElementById ( 'hintButton' ).value = "Hide Hint";
				document.getElementById ( 'timeLeft' ).style.display = "block";
			}
			else
			{
				document.getElementById ( 'hintButton' ).value = "Show Hint";
				document.getElementById ( 'timeLeft' ).style.display = "none";
			}
		}
		</script>
	
		<div class="row-fluid">
			<div class="span3">
			</div>

			<div class="span9">
				<div class="centered">
					<input type="button" value="Show Hint" onClick="hintToggle()" id="hintButton" class="btn">
					<br>
					<div id="timeLeft" style="display: none;" class="hint"></div>
				</div>
			</div>
		</div>

	</div>
	
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/showdown.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/cookiemanager.js"></script>
</body>

</html>
