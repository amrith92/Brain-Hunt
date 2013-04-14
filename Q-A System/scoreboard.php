<?php
	require_once ( '../common/include_database.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>GLUG: BRAIN-HUNT | Scoreboard</title>
	<link rel="stylesheet" href="css/normalize.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1>Scoreboard <a href="<?php echo $_SERVER['PHP_SELF']; ?>" title="Refresh"><i class="icon-refresh"></i></a></h1>
				<hr />
				<table class="table table-striped">
					<thead>
						<tr>
							<td>#</td>
							<td>Team</td>
							<td>Score</td>
						</tr>
					</thead>
					<?php
						$sql = "SELECT `username`, `points` FROM `user_auth` INNER JOIN user_state AS u ON ID=u.user_ID ORDER BY u.points DESC;";
						$stmt = $dbh->prepare($sql);
						$stmt->execute();
						$results = $stmt->fetchAll();
						$ct = 1;

						foreach ($results as $v) {
					?>
					<tr <?php if ($v['points'] >= 1200) echo 'class="success"'; else if ($v['points'] >= 800) echo 'class="warning"'; else if ($v['points'] == 0) echo 'class="error"'; ?>>
						<td>
							<?php if ($v['points'] >= 1200) echo "&bull;"; else echo $ct++; ?>
						</td>
						<td>
							<?php echo $v['username']; ?>
						</td>
						<td>
							<?php echo $v['points']; ?>
						</td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
