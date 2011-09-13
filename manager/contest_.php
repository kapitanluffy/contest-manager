<?php
(!$loggedin) ? 	header('Location: index.php') : '';
$id_value = '';
$name_value = 'Contest Name';
$num_value = '';
$top_value = 0;
$post_id = '';
$do_value = 'add';
$input_class = 'blur_input';

$pagi = new Page(null,'contest','contest',99999);
$contestList = $db->result_array(null, $pagi->get['resource']);

$p1 = new Page(null, 'criterias', 'criteria',99999);
$c1 = $db->result_array(null,$p1->get['resource']);

$p2 = new Page(null, 'contestants', 'contestant',99999);
$c2 = $db->result_array(null,$p2->get['resource']);

if(mysql_num_rows($pagi->get['resource']) == 0){
        $msg = "No contest existing. Add one!";
}

if(isset($_GET['msg'])){
	if(get('msg') == 1){
		$msg = "contest already exists";
	}
	if(get('msg') ==3){
		$msg = 'contest successfully added';
	}
	if(get('msg') ==4){
		$msg = "Updated successfully";
	}
	if(get('msg') ==5){
		$msg = "Deleted successfully";
	}
	if(get('msg') ==6){
		$msg = "Criteria percentage must be equal to 100%";
	}
}

if(isset($_POST['do']) || isset($_GET['do'])){
	if(post('do') == 'add'){
		$contestName = post('name');
		$contestantNames = post('contestants');
		$criterias = post('criterias');
		$postContest = array('id'=>post('postContest'),'limit'=>post('top'));
		$cols = array(
			'name'=>$contestName,
			'mid'=>$_SESSION['id'],
			'criterias'=>addslashes(serialize($criterias)),
			'contestants'=>addslashes(serialize($contestantNames)),
			'postContest'=>addslashes(serialize($postContest))
		);
		$name_exist = $db->select('contest',"where name='$cols[name]'");
		if(@array_sum($criterias) != 100){
			header("Location: contest.php?do=add&msg=6");
		} else if(mysql_num_rows($name_exist) >= 1){
			header("Location: contest.php?msg=1");
		} else {
			$db->insert('contest',$cols);
			header("Location: contest.php?msg=3");
		}
	}
	if(post('do') == 'edit'){
		$contestId = post('id');
		$contestName = post('name');
		$contestantNames = post('contestants');
		$criterias = post('criterias');
		$postContest = array('id'=>post('postContest'),'limit'=>post('top'));
		$cols = array(
			'name'=>$contestName,
			'mid'=>$_SESSION['id'],
			'criterias'=>addslashes(serialize($criterias)),
			'contestants'=>addslashes(serialize($contestantNames)),
			'postContest'=>addslashes(serialize($postContest))
		);
		if(array_sum($criterias) != 100){
			header("Location: contest.php?do=edit&id=$_GET[id]&msg=6");
		} else {
			$db->update('contest',$cols,"where id='".$contestId."'");
			header("Location: contest.php?msg=4");
		}
	}
	if(get('do') == 'edit'){
		$s = $db->select('contest',"where id='".get('id')."'");
		$s = $db->result_array(null,$s);
		$id_value = $s[0]['id'];
		$name_value = $s[0]['name'];
		$criterias_selected = unserialize($s[0]['criterias']);
		$top_value = @unserialize($s[0]['postContest']);
		$post_id = $top_value['id'];
		$top_value = $top_value['limit'];
		$contestants_selected = unserialize($s[0]['contestants']);
		$do_value = 'edit';
		$input_class = 'focus_input';
	}	
	if(get('do') == 'delete'){
		if($db->delete('contest',"where id='".get('id')."'") !== false){
			header("Location: contest.php?msg=5");
		}
	}
}

$contest = new form('contest','post');
$form['start'] = $contest->start();
$form['name'] = $contest->cid(null,"$input_class")->text('name', post('name',$name_value));
$form['id'] = $contest->hidden('id', post('blah',$id_value));
$form['go'] = $contest->submit('do',post('blah',$do_value));
$form['stop'] = $contest->stop();
?>