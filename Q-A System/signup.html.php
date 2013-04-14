<?php
	require_once ( '../common/include_home.php' );
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
				<h1><a href="<?php echo $HOME; ?>">&larr;</a>Registration for Brain Hunt</h1>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<hr />
				<form action="signup.php" method="post">
					<div class="controls">
						<label for="uid">Team Name</label>
						<input type="text" name="username" id="uid">

						<label for="passwd">Password</label>
						<input type="password" name="password" id="passwd">
					</div>
					<div class="form-inline">
						<label for="mn1">Member 1 Name</label>
						<input type="text" name="name1" id="mn1">

						<label for="mn1e">Member 1 Email</label>
						<input type="email" name="email1" id="mn1e" placeholder="VIT Email Only">
					</div>
					<br />
					<div class="form-inline">
						<label for="mn2">Member 1 Name</label>
						<input type="text" name="name2" id="mn2">

						<label for="mn2e">Member 2 Email</label>
						<input type="email" name="email2" id="mn2e" placeholder="VIT Email Only">
					</div>
					<br />
					<div class="controls">
						<button type="submit" class="btn">Sign-Up!</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="js/bootstrap.min.js"></script>
</body>
</html>
