<?php require('session.php') ?>
<?php 
if(!isset($_SESSION['user_id']))
{
	header('Location: http://recursivehow.com/'); 
	exit; 
}
?>
<html>
<head>
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="js/navigation.js"></script>
<script src="js/level.js"></script>
<title>Recursion Page</title>
<link rel="stylesheet" type="text/css" href="css/navigation.css">
<link rel="stylesheet" type="text/css" href="css/levelContent.css">
<link rel="stylesheet" type="text/css" href="css/dropdown.css">
<link rel="stylesheet" type="text/css" href="css/home_bar.css">
<link rel="stylesheet" type="text/css" href="css/background.css">
</head>
<div class="homeBar homeBarText">Recursivehow.com</div>
<div id="home"></div>
<ul class="navigationBar">
	<div class="navigationSection"><a class="navigationLink" href="userhome.php">Home</a></div>
	<div class="navigationSection dropdown navigationDropdownSection">
	<div class="dropdown-content">
	<form action="level.php" method="post" id="levelForm">
	</form>
	<script type="text/javascript">
  		levels(<?php echo ($_SESSION['progress'] + 1); ?>);
	</script>

	</div>
	<p class="navigationLink">Levels</p>
	</div>
	<div class="navigationSection right"><a class="navigationLink" href="logout.php">Logout</a></div>
</ul>
<body>
<center><p><?php echo $_SESSION['encourage'] ?></p></center>
<h2 class="levelContent"><?php echo $_SESSION['message']; ?></h2>
<div class="levelContent">
<?php require('../hidden/levels/levelshell.php'); ?>
</div>
</body>
</html>
