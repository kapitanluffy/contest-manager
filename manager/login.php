<?php
$login = new form('login');
$forms = array();

$forms['login']['start'] = $login->start();
$forms['login']['user'] = $login->text('user');
$forms['login']['pass'] = $login->text('pass');
$forms['login']['stop'] = $login->stop();

?>