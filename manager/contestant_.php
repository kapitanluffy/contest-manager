<?php
(!$loggedin) ? 	header('Location: index.php') : '';
$id_value = '';
$name_value = 'Contestant Name';
$num_value = '';
$do_value = 'add';
$input_class = 'blur_input';

$pagi = new Page(null,'contestants',5);

if(mysql_num_rows($pagi->get['resource']) == 0){
        $msg = "No contestants existing. Add one!";
}

if(isset($_GET['msg'])){
	if(get('msg') == 1){
		$msg = "Contestant already exists";
	}
	if(get('msg') == 2){
		$msg = "Contestant #$cols[num] already exists";
	}
	if(get('msg') ==3){
		$msg = 'Contestant successfully added';
	}
	if(get('msg') ==4){
		$msg = "Updated successfully";
	}
	if(get('msg') ==5){
		$msg = "Deleted successfully";
	}
}

if(isset($_POST['do']) || isset($_GET['do'])){
	if(post('do') == 'add'){
		$cols = array(
			'number'=>post('num'),
			'name'=>post('name')
		);
		$name_exist = $db->select('contestants',"where name='$cols[name]'");
		if(mysql_num_rows($name_exist) >= 1){
			header("Location: contestant.php?msg=1");
		} else {
			$db->insert('contestants',$cols);
			header("Location: contestant.php?msg=3");
		}
	}
	if(post('do') == 'edit'){
		$cols = array(
			'number'=>post('num'),
			'name'=>post('name')
		);
		$db->update('contestants',$cols,"where id='".post('id')."'");
		header("Location: contestant.php?msg=4");
	}
	if(get('do') == 'edit'){
		$s = $db->select('contestants',"where id='".get('id')."'");
		$s = $db->result_array(null,$s);
		$id_value = $s[0]['id'];
		$name_value = $s[0]['name'];
		$num_value = $s[0]['number'];
		$do_value = 'edit';
		$input_class = 'focus_input';
	}	
	if(get('do') == 'delete'){
		if($db->delete('contestants',"where id='".get('id')."'") !== false){
			header("Location: contestant.php?msg=5");
		}
	}
}

$contestant = new form('contestant','post');

$form['start'] = $contestant->start();
$form['num'] = $contestant->cid(null,'short')->text('num',post('num',$num_value));
$form['name'] = $contestant->cid(null,"$input_class")->text('name', post('name',$name_value));
$form['id'] = $contestant->hidden('id', post('blah',$id_value));
$form['go'] = $contestant->submit('do',post('blah',$do_value));
$form['stop'] = $contestant->stop();

?>