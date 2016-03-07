<?php include('session.php'); ?>
<p>More content to be added in the future. However if you would like to continue for whatever reason type more in the field below and click submit.</p>
<form action="userhome.php" method="post">
<input type="text" name="answer">
<input type="submit" value="submit answer">
</form>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
