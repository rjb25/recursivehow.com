<?php
require('session.php');

if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token']))
{
    $_SESSION['error_error_message'] = 'Please enter both a username and a password';
}
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $_SESSION['error_message'] = 'Incorrect token, try restarting your browser and trying again.';
}
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
    $_SESSION['error_message'] = 'Incorrect Length for Username, must be above four characters and below 20.';
}
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
    $_SESSION['error_message'] = 'Incorrect Length for Password';
}
elseif (ctype_alnum($_POST['username']) != true)
{
    $_SESSION['error_message'] = "Username must be alpha numeric";
}
elseif (ctype_alnum($_POST['password']) != true)
{
        $_SESSION['error_message'] = "Password must be alpha numeric";
}
else
{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $password = sha1( $password );

    try
    {
		require('../hidden/connect_jason.php');

        $stmt = $dbh->prepare("INSERT INTO users (username, password, progress) VALUES (:username, :password, 0)");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        unset( $_SESSION['form_token'] );

		$_SESSION['password'] = $_POST['password'];
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['addUserLogin'] = true;
        $_SESSION['error_message'] = 'New user added';
		header('Location: login_submit.php');
		exit;
    }
    catch(Exception $e)
    {
        if( $e->getCode() == 23000)
        {
            $_SESSION['error_message'] = 'Username already exists';
        }
        else
        {
            $_SESSION['error_message'] = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>
<?php
header('Location: adduser.php');
exit;
?>
