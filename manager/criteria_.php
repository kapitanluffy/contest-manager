<?php
(!$loggedin) ? 	header('Location: index.php') : '';
$id_value = '';
$name_value = 'Criteria Name';
$num_value = '';
$do_value = 'add';
$input_class = 'blur_input';

$pagi = new Page(null,'criterias',5);

if(mysql_num_rows($pagi->get['resource']) == 0){
        $msg = "No criterias existing. Add one!";
}

if(isset($_GET['msg'])){
	if(get('msg') == 1){
		$msg = "Criteria already exists";
	}
	if(get('msg') ==3){
		$msg = 'criteria successfully added';
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
			'name'=>post('name'),
			'percentage'=>post('percent')
		);
		$name_exist = $db->select('criterias',"where name='$cols[name]'");
		if(mysql_num_rows($name_exist) >= 1){
			header("Location: criteria.php?msg=1");
		} else {
			$db->insert('criterias',$cols);
			header("Location: criteria.php?msg=3");
		}
	}
	if(post('do') == 'edit'){
		$cols = array(
			'percentage'=>post('percent'),
			'name'=>post('name')
		);
		$db->update('criterias',$cols,"where id='".post('id')."'");
		header("Location: criteria.php?msg=4");
	}
	if(get('do') == 'edit'){
		$s = $db->select('criterias',"where id='".get('id')."'");
		$s = $db->result_array(null,$s);
		$id_value = $s[0]['id'];
		$name_value = $s[0]['name'];
		$num_value = $s[0]['percentage'];
		$do_value = 'edit';
		$input_class = 'focus_input';
	}	
	if(get('do') == 'delete'){
		if($db->delete('criterias',"where id='".get('id')."'") !== false){
			header("Location: criteria.php?msg=5");
		}
	}
}

$criteria = new form('criteria','post');

$form['start'] = $criteria->start();
$form['percent'] = $criteria->cid(null,'short')->text('percent',post('percent',$num_value));
$form['name'] = $criteria->cid(null,"$input_class")->text('name', post('name',$name_value));
$form['id'] = $criteria->hidden('id', post('blah',$id_value));
$form['go'] = $criteria->submit('do',post('blah',$do_value));
$form['stop'] = $criteria->stop();
?>