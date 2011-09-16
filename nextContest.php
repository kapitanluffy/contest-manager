<?php 
include 'header.php';
if(!$loggedin){header('Location: judge.php');}
if(empty($_POST['nextContest'])){ header('Location: index.php'); }

	$postContest = unserialize(post('postContest'));
	$limit = $postContest['limit'];
	$supahquery = "select DISTINCT contestantId, sum(total) as total FROM (SELECT DISTINCT contestantId, total FROM scores WHERE contestId=".post('preContest').") AS MYTABLE group by contestantId order by total desc";
	$totalScoresRes = $db->query($supahquery);
	$totalScores = $db->result_array('contestantId',$totalScoresRes);
	$no = 1; $oldScore = 0;
	foreach($totalScores as $id => $score){
		if($no > $limit){	break;}
		if($oldScore != $score['total']){ $no+=1; }
		$top[$no][$id] = $score;
		$oldScore = $score['total'];
	}
	
	$contestantId = array();
	foreach($top as $index => $no){
		foreach($no as $i => $n){
			$contestantId[] = $n['contestantId'];
		}
	}

	if(!empty($contestantId)){
		$cols = array(
			'contestants'=>addslashes(serialize($contestantId))
		);
		$db->update('contest',$cols,"where id='".$postContest['id']."'");
		header("Location: contest.php?id=$postContest[id]");
	}

?>