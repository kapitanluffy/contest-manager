<?php 
include 'header.php';

if(!empty($_POST['nextContest'])){
	$postContest = unserialize(post('postContest'));
	$totalScores = $db->select('scores',"WHERE contestId='".post('preContest')."' ORDER BY total desc","DISTINCT total");
	$totalScores = $db->result_array(null,$totalScores);
	$no = 1;
	foreach($totalScores as $index => $score){
		$toppers = $db->select('scores',"WHERE contestId='".post('preContest')."' AND total='$score[total]' ");
		if($no <= $postContest['limit']){
			$top[$no] = $db->result_array('id',$toppers);
			$no++;
		} else {
			break;
		}
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
	
}

?>