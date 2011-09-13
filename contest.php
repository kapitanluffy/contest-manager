<?php 
include 'header.php';
if(isset($_REQUEST['id'])){
	$criterias_array = array_keys(unserialize($contests[get('id')]['criterias']));
	$contestants_array = unserialize($contests[get('id')]['contestants']);
	$criterias = ''; $contestants = '';
	if(is_array($criterias_array)){
		$criterias = "'".implode("','",$criterias_array)."'";
	}
	if(is_array($contestants_array)){
		$contestants = implode(',',$contestants_array);
	}
} else {
	header("Location: index.php");
}

$msg = '';
if(isset($_GET['msg'])){
	if(get('msg') == 1){
		$msg = 'Score must be less than or equal to 100';
	}
}

// insert & update
if(isset($_POST['do'])){
	$contestantId = post('cid');
	$contestId = post('id');
	$total = array_sum(post('criterias'));
	$cols = array(
		'contestId'=>$contestId,
		'contestantId'=>$contestantId,
		'scores'=>addslashes(serialize(post('criterias'))),
		'total'=>$total
	);
	$select = $db->select('scores',"WHERE contestantId='$contestantId' AND contestId='$contestId'");
	if($total > 100){
		header("Location: ?id=$_GET[id]&msg=1");
	}else if($db->rows_affected($select) >= 1){
		$db->update('scores',$cols,"WHERE contestantId='$contestantId' AND contestId='$contestId'")or die(mysql_error());
	} else {
		$db->insert('scores',$cols)or die(mysql_error());
	}
}

$score = new form('score');

$criterias = $db->select('criterias',"WHERE name IN ($criterias)")or die(mysql_error() . "No criterias yet, please <a href='/scoring/manager/contest.php?do=edit&id=$_GET[id]'>add</a> one");
$contestants = $db->select('contestants',"WHERE id IN ($contestants)")or die("No contestants yet, please <a href='/scoring/manager/contest.php?do=edit&id=$_GET[id]'>add</a> one");

$criterias = $db->result_array(null,$criterias);
$contestants = $db->result_array(null,$contestants);
$criteriaCount = count($criterias);

?>

<?php foreach($contestants as $i => $c){ ?>
<div><form method='post' name='save_scores'>
<?php echo $score->hidden('id',$_REQUEST['id']); ?>
<?php echo $score->hidden('cid',$c['id']); ?>
<?php echo "#$c[number] $c[name]" ?>
<ul>
<?php 
foreach($criterias as $ii => $cc){ 
$ccScores = $db->result_array(null,$db->select('scores',"WHERE contestId='$_GET[id]' AND contestantId='$c[id]'"));
$ccScores = @unserialize($ccScores[0]['scores']);
?>
<li><?php echo "$cc[name] $cc[percentage]% ".@$score->text("criterias[$cc[name]]",$ccScores[$cc['name']]); ?></li>
<?php } ?>
</ul>
<?php echo $score->submit('do','save'); ?>
</form></div>
<?php } ?>

<form action='results.php' method='post'>
	<input type='hidden' name='preContest' value='<?php echo $contests[get('id')]['id']; ?>' />
	<input type='hidden' name='postContest' value='<?php echo $contests[get('id')]['postContest']; ?>' />
	<input type='submit' name='viewresults' value='View Results &raquo;' />
</form>

<?php if(!empty($contests[get('id')]['postContest'])){ ?>
	<form action='nextContest.php' method='post'>
		<input type='hidden' name='preContest' value='<?php echo $contests[get('id')]['id']; ?>' />
		<input type='hidden' name='postContest' value='<?php echo $contests[get('id')]['postContest']; ?>' />
		<input type='submit' name='nextContest' value='Proceed &raquo;' />
	</form>
<?php } ?>