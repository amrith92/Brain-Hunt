<?php
	require_once ( '../common/include_database.php' );

	if (isset($_POST['myvent'])) {
		$sql = "INSERT INTO commentary(comment) VALUES (:vent);";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':vent', stripslashes(htmlspecialchars($_POST['myvent'], ENT_QUOTES, 'UTF-8')));
		$stmt->execute();
		unset($_POST['myvent']);
	}
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
	<title>Add Commentary</title>
</head>
<body>
	<form action="?" method="POST">
		<label for="ventid">Commentary</label>
		<textarea id="ventid" name="myvent"></textarea><br />
		<button class="btn">Add &raquo;</button>
	</form>
</body>
</html>
