<?php
require('session.php');

if(!isset($_SESSION['user_id']))
{
	header('Location: http://recursivehow.com/');
	exit;
}
else
{
	try
	{
		require('../hidden/connect_jason.php');
		$stmt = $dbh->prepare("update users set progress = 1 + progress where id = :id ");
		$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		require('userinfo.php');
		header('Location: http://recursivehow.com/userhome.php');
		exit;
	}
	catch (Exception $e)
	{
	}
}
?>

