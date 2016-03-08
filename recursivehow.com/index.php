<?php require('session.php'); ?>
<html>
<head>
<title>Login</title>
<script src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/background.css">
</head>
<body>
<?php if( !isset( $_SESSION['user_id'] ) ): ?>
<center><h2>Login</h2></center>

<form action="login_submit.php" name="login" method="post" onsubmit="return loginValidation()">
	<div id = "div">

		<center><?php if(isset($_SESSION['error_message'])) echo $_SESSION['error_message'] ;?></center>
		<label for="username">Username</label>
		<input type="text" id="username" name="username" value="" maxlength="20" />

		<label for="password">Password</label>
		<input type="password" id="password" name="password" value="" maxlength="20" />

		<input type="submit" value="Login" />

		<center><p><a href="adduser.php">Create User</a></p></center>
	</div>
</form>
<?php else: ?>
<?php header('Location: userhome.php'); exit; ?>

<?php endif; ?>
</body>
</html>
