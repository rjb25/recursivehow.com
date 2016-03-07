<?php include('session.php') ?>
<?php
	$_SESSION['file'] =$_POST['level']  ;
header('Location: userhome.php');
exit;
?>
