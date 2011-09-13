<?php 
include 'header.php';

if(!empty($_POST['viewresults'])){
	$totalScoresRes = $db->select('scores',"WHERE contestId='".post('preContest')."' ORDER BY total desc");
	$limit = $db->rows_affected($totalScoresRes);
	$totalScores = $db->result_array(null,$totalScoresRes);
	$no = 1;
	foreach($totalScores as $index => $score){
		$toppers = $db->select('scores',"WHERE contestId='".post('preContest')."' AND total='$score[total]' ");
		if($no > $limit){
			break;
		}
		$top[$no] = $db->result_array('contestantId',$toppers);
		$no++;
	}

for($no = 1; $no <= $limit; $no++){
	echo "<h1>Top #$no</h1>";
	foreach($top[$no] as $contestant){
		$cdetails = $db->result_array(null,$db->select('contestants',"WHERE id='$contestant[contestantId]'"));
		foreach($cdetails as $cdetail){
		echo "<div>#$cdetail[number] $cdetail[name] ".$top[$no][$cdetail['id']]['total']."%</div>";
		}
	}	
}

echo '<a href="contest.php?id='.post('preContest').'">Back to Scoring</a>';

if(!empty($_POST['postContest'])){
echo "
	<form action='nextContest.php' method='post'>
		<input type='hidden' name='preContest' value='".post('preContest')."' />
		<input type='hidden' name='postContest' value='".post('postContest')."' />
		<input type='submit' name='nextContest' value='Proceed &raquo;' />
	</form>
";
}

}

?>