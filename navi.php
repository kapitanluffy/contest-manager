Hello Judge <strong><?php echo $_SESSION['name']; ?></strong>, 

<div id='task'>
<?php if(isset($_GET['id'])){ ?>
	<a href='#'>Pick a contestant</a>
<?php } ?>
<?php if(!empty($_POST['preContest'])){ ?>
	<a href="contest.php?id=<?php echo post('preContest'); ?>">Back to Scoring</a>
<?php } ?>
<a href='index.php'>Choose a contest</a>
<?php if(isset($_GET['id'])){ ?>
	<a href='#view_results' onClick='viewResults.submit()'>View Results</a>
<?php } ?>
<?php if(!empty($postContest['id']) || !empty($_POST['postContest'])){ ?>
	<a href='#next_contest' onClick='nextContest.submit()'>Next Contest</a>
<?php } ?>
<a href='?do=logout'>Leave</a>
</div>