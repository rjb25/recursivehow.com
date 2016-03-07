<?php include('session.php'); ?>
<p>You most sincerely are very bored. Go to bed.</p>
<?php if ($_POST['answer'] == 'more'): ?>
<?php $_SESSION['correct'] = 'true'; ?>
<?php endif; ?>
