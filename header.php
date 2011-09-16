<?php 
session_start();
include 'crowd/mysql.php';
include 'crowd/form.php';
include 'crowd/page.php';
include 'crowd/debug.php';
include 'crowd/functions.php';
$db = new mysql('scoring_db','')or die();

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

// message
if(isset($_GET['msg'])){
	if(get('msg') == 1){
		$msg = 'Score must be less than or equal to 100';
	}
	if(get('msg') == 2){
		$msg = "Selected contest has no criterias yet, 
		please <a href='manager/criteria.php?do=edit&id=$_GET[id]'>add</a> one.<br/>
		You may refer to the <a href='manager/admin.php#CreatingCriterias'>Creating Criterias</a> section of the wiki.";
	}
	if(get('msg') == 3){
		$msg = "Selected contest has no contestants yet, 
		please <a href='manager/contest.php?do=edit&id=$_GET[id]'>add</a> one.<br/>
		You may refer to the <a href='manager/admin.php#AddingContestants'>Adding Contestants</a> section of the wiki.";
	}
}

// check if logged in
$loggedin = false;
if(isset($_SESSION['name']) && !empty($_SESSION['name'])){
	$loggedin = true;
}

$contests = $db->select('contest');
$contests = $db->result_array('id',$contests);

?>