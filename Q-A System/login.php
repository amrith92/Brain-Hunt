<?php

if ( ! isset ( $_SESSION['logged-in'] ) )
{
	if ( isset ( $_POST['username'] ) )
	{
		require_once ( "../common/include_database.php" );
	
		$query = "SELECT * FROM user_auth WHERE username=:username;";
		$stmt = $dbh->prepare ( $query );
		$stmt->bindParam ( ":username", $_POST['username'] );
		$stmt->execute ( );
		$result = $stmt->fetchAll ( );
	
		$flag = false;
		foreach($result as $row)
		{
			if ( $row['password'] == md5 ( $_POST['password'] ) )
			{
				$flag = true;
			
				require_once('../common/include_session.php');
			
				$_SESSION['logged-in'] = true;
				$_SESSION['id'] = $row['ID'];
				$_SESSION['name'] = $row['name'];
			
				header('Location: profile.php');

				exit;
			
			}		
		}
		
		if ( $flag == false )
		{
			require_once ( "../common/include_home.php" );
			header ( "Location: $HOME/Q-A System/login.php?error=1" );
		}
	}
}
else
{
	header('Location: profile.php');
}

?>

<!DOCTYPE html>

<html>

<head>
	<title>Welcome</title>
</head>

<body>

	<form method="post" action="login.php">
	
		<label for="username">Username : </label>
		<input id="username" name="username">
		<br>
	
		<label for="password">Password : </label>
		<input type="password" id="password" name="password">
		<br>
	
		<input type="submit" value="Login">
		<?php
			if ( isset ( $_GET['error'] ) )
			{
				if ( $_GET['error'] == "1" )
					echo "<br><span style=\"color: red\">Incorrect Credentials!</span>";
				else if ( $_GET['error'] == "2" )
					echo "<br><span style=\"color: red\">Login to View that Page!</span>";
			}
		?>
	
	</form>
	
</body>

</html>
