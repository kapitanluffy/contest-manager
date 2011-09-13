<?php 
session_start();
include 'crowd/mysql.php';
include 'crowd/form.php';
include 'crowd/page.php';
include 'crowd/debug.php';
include 'crowd/functions.php';
$db = new mysql('scoring_db','boom')or die();

$error = '';
$msg = '';
$form = array();

// wait for logout trigger
if(isset($_GET['do'])){
	if($_GET['do'] == 'logout'){
		session_destroy();
		header('Location: index.php');
	}
}

$contests = $db->select('contest');
$contests = $db->result_array('id',$contests);

?>