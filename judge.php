<?php
include 'header.php';
if($loggedin){header('Location: index.php');}

if(!empty($_POST['do'])){
	$_SESSION['name'] = strtolower(trim(htmlentities($_POST['judge'])));
	header('Location: index.php');
}


$judge = new Form('judgename','post');

echo $judge->start();
echo $judge->text('judge','Enter judge name');
echo $judge->submit('do','enter');
echo $judge->stop();

?>