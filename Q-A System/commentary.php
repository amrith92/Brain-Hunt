<?php
	require_once ( '../common/include_database.php' );

	if (isset($_POST['myvent'])) {
		require_once ( '../common/include_session.php' );
		if (isset($_SESSION['id'])) {
			$sql = "INSERT INTO vents(user_id, vent) VALUES (:id, :vent);";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id', $_SESSION['id']);
			$stmt->bindParam(':vent', stripslashes(htmlspecialchars($_POST['myvent'])));
			$stmt->execute();
		}
		unset($_POST['myvent']);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>GLUG: BRAIN-HUNT | Commentary</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<style type="text/css">
#ventid {
	width: 90%;
}

.myvent, .comment {
	border-radius: 3px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	background-color: #fff;
	margin: 12px;
	padding: 4px;
}

.comment {
background: #ffffff;
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPHJhZGlhbEdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNzUlIj4KICAgIDxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiNmZmZmZmYiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZTVlNWU1IiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L3JhZGlhbEdyYWRpZW50PgogIDxyZWN0IHg9Ii01MCIgeT0iLTUwIiB3aWR0aD0iMTAxIiBoZWlnaHQ9IjEwMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-radial-gradient(center, ellipse cover,  #ffffff 0%, #e5e5e5 100%);
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5));
background: -webkit-radial-gradient(center, ellipse cover,  #ffffff 0%,#e5e5e5 100%);
background: -o-radial-gradient(center, ellipse cover,  #ffffff 0%,#e5e5e5 100%);
background: -ms-radial-gradient(center, ellipse cover,  #ffffff 0%,#e5e5e5 100%);
background: radial-gradient(ellipse at center,  #ffffff 0%,#e5e5e5 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=1 );
}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Commentary <a href="<?php echo $_SERVER['PHP_SELF']; ?>" title="Refresh"><i class="icon-refresh"></i></a></h1>
				<hr />
				<div id="commentary" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
<?php
	$sql = "SELECT comment FROM commentary ORDER BY tstamp DESC LIMIT 0,10;";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$comments = $stmt->fetchAll();

	foreach ($comments as $v) {
?>
					<div class="comment">
						<?php echo $v['comment']; ?>
					</div>
<?php
	}
?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<h1>Vent your frustration (here) <a href="<?php echo $_SERVER['PHP_SELF']; ?>" title="Refresh"><i class="icon-refresh"></i></a></h1>
				<hr />
				<div id="add-your-vent">
					<form action="?" method="POST">
						<label for="ventid">Your vent</label>
						<textarea id="ventid" name="myvent"></textarea><br />
						<button class="btn">Vent Away!</button>
					</form>
				</div>
				<div id="vent" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
<?php
	$sql = "SELECT username, vent FROM vents INNER JOIN user_auth ON user_id=ID ORDER BY tstamp DESC LIMIT 0,10;";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$comments = $stmt->fetchAll();

	foreach ($comments as $v) {
?>
					<div class="myvent">
						<div>
							<strong><?php echo htmlspecialchars($v['username'], ENT_QUOTES, 'UTF-8'); ?> says:</strong>
						</div>
						<div>
							<?php echo $v['vent']; ?>
						</div>
					</div>
<?php
	}
?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
