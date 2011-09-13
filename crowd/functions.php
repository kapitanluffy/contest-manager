<?php 

function say($name){
	if(isset($name)){
		echo $name;
		return true;
	}
	return false;
}

function parse_get($str = '',$names = array()){
	$get = '';
	foreach($_GET as $name => $val){
		if(in_array($name,$names) || empty($names)){
			$get .= $name.'='.$val.'&';
		}
	}
	return $get . $str;
}

?>