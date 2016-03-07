<?php if(!session_id()) session_start();?>
<html>
<head>
</head>
<body>
<p>Welcome to level <?php echo $_SESSION['file']; ?></p>
<br>
<?php if ($_SESSION['progress'] >= ($_SESSION['file']-1)): ?>
<?php require('level'.$_SESSION['file'].'.php') ?>
<?php if ($_SESSION['correct'] =="true"): ?>
<?php $_SESSION['correct'] = 'false';?>
<?php if ($_SESSION['progress'] ==($_SESSION['file']-1)): ?>
<?php require('update_progress.php'); ?>
<?php endif;?>
<?php $_SESSION['file']++; ?>
<?php header('Location: userhome.php');?>
<?php endif;?>
<?php else: ?>
<?php echo "You do not have access to that level yet" ?>
<?php endif; ?>
</body>
</html>

