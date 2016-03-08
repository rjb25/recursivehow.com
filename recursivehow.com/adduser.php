<?php

require('session.php');

$form_token = md5(uniqid('authorization', true));

$_SESSION['form_token'] = $form_token;
?>
<?php if( !isset( $_SESSION['user_id'] ) ): ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/background.css">
<title>Login</title>
<script src="js/validation.js"></script>
</head>

<body>
<center><h2>Add User</h2></center>
<form name="login" action="adduser_submit.php" method="post" onsubmit="return addUserValidation()">
	<div id="div">
		<center><?php if(isset($_SESSION['error_message'])) echo $_SESSION['error_message'] ;?></center>
		<label for="username">Username</label>
		<input type="text" id="username" name="username" value="" maxlength="20" />

		<label for="password">Password</label>
		<input type="password" id="password" name="password" value="" maxlength="20" />

		<label for="confirmpassword">Confirmation</label>
		<input type="password" id="confirmation" name="confirmation" value="" maxlength="20" />

		<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />

		<input type="submit" value="Add User" />

		<center><p><a href="http://recursivehow.com/">Log In</a></p></center>
	</div>
</form>

</body>
</html>
<?php else: ?>
<?php header('Location: userhome.php'); exit; ?>

<?php endif; ?>
