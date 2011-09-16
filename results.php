<?php 
include 'header.php';
if(!$loggedin){header('Location: judge.php');}
if(!empty($_POST['viewresults'])){ header('Location: index.php'); }

	$supahquery = "select DISTINCT contestantId, sum(total) as total FROM (SELECT DISTINCT contestantId, total FROM scores WHERE contestId=".post('preContest').") AS MYTABLE group by contestantId order by total desc";
	$totalScoresRes = $db->query($supahquery);
	$limit = $db->rows_affected($totalScoresRes);
	$totalScores = $db->result_array('contestantId',$totalScoresRes);
	$no = 0; $oldScore = 0;
	foreach($totalScores as $id => $score){
			if($no > $limit){       break; }
			if($oldScore != $score['total']){ $no+=1; }
			$top[$no][$id] = $score;
			$oldScore = $score['total'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<title></title>
<style>
@import url(assets/style.css);
</style>
</head>
<body>
<?php include 'navi.php'; ?>
<?php 
for($no = 1; $no < $limit; $no++){
	echo "<h1>Top #".$no."</h1>";
	foreach($top[$no] as  $id => $contestant){
			$cdetails = $db->result_array(null,$db->select('contestants',"WHERE id='$contestant[contestantId]'"));
			foreach($cdetails as $cdetail){
			echo "<div>#$cdetail[number] $cdetail[name] ".$top[$no][$id]['total']."% = ".round($top[$no][$id]['total']/post('numberOfJudges'),2)."</div>";
			}
	}       
}
?>
<?php if(!empty($_POST['postContest'])){ ?>
<form name='nextContest' action='nextContest.php' method='post'>
	<input type='hidden' name='preContest' value='<?php echo post('preContest'); ?>' />
	<input type='hidden' name='postContest' value='<?php echo post('postContest'); ?>' />
	<input type='hidden' name='numberOfJudges' value='<?php echo $contests[get('id')]['numberOfJudges']; ?>' />      <!--<input type='submit' name='nextContest' value='Proceed &raquo;' />-->
</form>
<?php } ?>
</body>
</html>
