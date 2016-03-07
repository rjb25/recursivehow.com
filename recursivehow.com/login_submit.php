<?php

require('session.php');

$success =false;

if ($_SESSION['addUserLogin'] == true){
	$_POST['username'] = $_SESSION['username'];
	$_POST['password'] = $_SESSION['password'];
}
$_SESSION['addUserLogin'] = false;

if(isset ($_SESSION['user_id'])){
	//$_SESSION['error_message'] = 'You are already logged in.';
}elseif(!isset( $_POST['username'], $_POST['password']))
{
    $_SESSION['error_message'] = 'Please enter a valid username and password';
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
    
try{
	require('../hidden/connect_jason.php');
        $stmt = $dbh->prepare("SELECT id FROM users 
                    WHERE username = :username AND password = :password");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        $user_id = $stmt->fetchColumn();

        if($user_id == false)
        {
                 $_SESSION['error_message'] = 'Login Failed';
        }
        else
        {
	   		     $_SESSION['user_id'] = $user_id;
		 		$success = true;
        }
    }
    catch(Exception $e)
    {
        $_SESSION['error_message'] = 'We are unable to process your request. Please try again later"';
    }
}
?>

<?php 
if ($success==false){
header('Location: index.php');
exit;
}elseif($success==true){
require('userinfo.php');
header('Location: userhome.php');
exit;
}else{
echo 'error';
}
?>
