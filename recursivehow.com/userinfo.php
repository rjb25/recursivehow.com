<?php
require('session.php');

if(!isset($_SESSION['user_id']))
{
	header('Location: http://recursivehow.com/'); exit; } else {
		try
		{
			require('../hidden/connect_jason.php');
			$stmt = $dbh->prepare("SELECT username FROM users 
				WHERE id = :id");
			$stmt2 = $dbh->prepare("SELECT progress FROM users 
				WHERE id = :id");

			$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt2->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

			$stmt->execute();
			$stmt2->execute();

			$username = $stmt->fetchColumn();
			$progress = $stmt2->fetchColumn();
			$_SESSION['progress'] = $progress;

			if($username == false)
			{
				$message = 'Access Error';
			}
			else
			{

				$_SESSION['file'] = $progress+1;
				switch ($progress){
				case 0:
					$_SESSION['encourage'] ='We will learn you yet young padawan';	
					break;
				case 1:
					$_SESSION['encourage'] ='Getting started';	
					break;
				case 2:
					$_SESSION['encourage'] ='Picking up steam';	
					break;
				case 3:
					$_SESSION['encourage'] ='wow the recursion is strong with this one';	
					break;
				case 4:
					$_SESSION['encourage'] ='Magnificent, a true recursor';	
					break;
				case 5:
					$_SESSION['encourage'] ='A thing of wonder';	
					break;
				case 6:
					$_SESSION['encourage'] ='Maybe I could learn a thing or two from you about recursion';	
					break;
				default:
					$_SESSION['encourage'] ='You are now a grand recusion master';
					break;
				}
				$_SESSION['message'] = 'Welcome '.$username.', your progress is: '.$progress;
			}
		}
		catch (Exception $e)
		{
			$message = 'We are unable to process your request. Please try again later"';
		}
	}
?>
