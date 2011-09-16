<?php 
include 'header.php';
if(!$loggedin){header('Location: judge.php');}
if(!isset($_REQUEST['id']) && empty($_REQUEST['id'])){ header("Location: index.php"); }

	$criterias_array = array_keys(unserialize($contests[get('id')]['criterias']));
	$contestants_array = unserialize($contests[get('id')]['contestants']);
	$postContest = unserialize($contests[get('id')]['postContest']);
	$criterias = ''; $contestants = '';
	if(is_array($criterias_array)){
		$criterias = "'".implode("','",$criterias_array)."'";
	}
	if(is_array($contestants_array)){
		$contestants = implode(',',$contestants_array);
	}

// insert & update
if(isset($_POST['do'])){
	$contestantId = post('cid');
	$contestId = post('id');
	$judge = $_SESSION['name'];
	$total = array_sum(post('criterias'));
	$cscores = addslashes(serialize(post('criterias')));
	$cols = array(
		'contestId'=>$contestId,
		'contestantId'=>$contestantId,
		'scores'=>$cscores,
		'total'=>$total,
		'judge'=>$judge
	);
	$select = $db->select('scores',"WHERE judge='$judge' AND contestantId='$contestantId' AND contestId='$contestId'");
	if($total > 100){
		header("Location: ?id=$_GET[id]&msg=1");
	}else if($db->rows_affected($select) >= 1){
		$scoreData = $db->result_array(null, $select);
		$db->update('scores',$cols,"WHERE judge='$judge' AND contestantId='$contestantId' AND contestId='$contestId'")or die(mysql_error());
	} else {
		$db->insert('scores',$cols)or die(mysql_error());
	}
}

$score = new form('score');

$criterias = $db->select('criterias',"WHERE name IN ($criterias)")or die(mysql_error() . "No criterias yet, please <a href='/scoring/manager/contest.php?do=edit&id=$_GET[id]'>add</a> one");
$contestants = $db->select('contestants',"WHERE id IN ($contestants)")or header("Location: index.php?id=$_GET[id]&msg=3");
$criterias = $db->result_array(null,$criterias);
$contestants = $db->result_array(null,$contestants);
$criteriaCount = count($criterias);

?>
<html>
<head>
<style>
@import url(assets/style.css);

#header {
	margin: 10px 0px;

}
.criterialist {
	display: none;
	list-style: none;
	padding: 0;
}
.criterialist li {
	margin-top: 10px;
}
.criterialist .criterianame {
	display: inline-block;
	min-width: 200px;
}

#contestantbox {
	margin-left: 10px;
}

.contestantname:hover {
	font-weight: bold;
}

.scorebox {
	width: 100px;
}
.selected {
	font-weight: bold;
}
</style>
<script type="text/javascript" src="assets/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(window.location.hash).next('.criterialist').toggle();
	$('.namediv').click(function(){
		$(this).next('.criterialist').toggle('slow');
	});	
	$('.namediv').click(function(){
		$(this).toggleClass('selected');
	});
});
</script>
</head>
<body>
<div id='header'>
<?php include 'navi.php'; ?>
<br/><?php echo $msg; ?>
</div>
<!-- contestants -->
<?php foreach($contestants as $i => $c){ ?>
<div class='contestantbox'>
<form method='post' name='save_scores'>
<?php echo $score->hidden('id',$_REQUEST['id']); ?>
<?php echo $score->hidden('cid',$c['id']); ?>
<?php echo "<div class='namediv' id='no$c[number]'><a href='#no$c[number]' class='contestantname'>#$c[number] $c[name]</a></div>" ?>
<ul class='criterialist'>
<?php 
foreach($criterias as $ii => $cc){ 
$ccScores = $db->result_array(null,$db->select('scores',"WHERE judge='$_SESSION[name]' AND contestId='$_GET[id]' AND contestantId='$c[id]'"));
$ccScores = @unserialize($ccScores[0]['scores']);
?>
<li class='criteriaitem'><?php 
echo "<span class='criterianame'>$cc[name] $cc[percentage]%</span>";
echo @$score->cid(null,'scorebox')->text("criterias[$cc[name]]",$ccScores[$cc['name']]); 
?></li>
<?php } ?>
<li><?php echo $score->submit('do','save'); ?></li>
</ul>
</form>
</div>
<?php } ?>
<form name='viewResults' action='results.php' method='post'>
	<input type='hidden' name='preContest' value='<?php echo $contests[get('id')]['id']; ?>' />
	<input type='hidden' name='postContest' value='<?php echo $contests[get('id')]['postContest']; ?>' />
	<input type='hidden' name='numberOfJudges' value='<?php echo $contests[get('id')]['numberOfJudges']; ?>' />
	<!--<input type='submit' name='viewresults' value='View Results &raquo;' />-->
</form>

<?php if(!empty($postContest['id'])){ ?>
	<form name='nextContest' action='nextContest.php' method='post'>
		<input type='hidden' name='preContest' value='<?php echo $contests[get('id')]['id']; ?>' />
		<input type='hidden' name='postContest' value='<?php echo $contests[get('id')]['postContest']; ?>' />
		<input type='hidden' name='numberOfJudges' value='<?php echo $contests[get('id')]['numberOfJudges']; ?>' />
		<!--<input type='submit' name='nextContest' value='Proceed &raquo;' />-->
	</form>
<?php } ?>
</body>
</html>