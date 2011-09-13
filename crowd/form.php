<?php 

class Form {

public $attrib = array();
public $classid;

function __construct($name, $method="get", $action=null, $enctype="application/x-www-form-urlencoded"){
	$this->attrib['start'] = "<form name='{$name}' method='{$method}' action='{$action}' enctype='{$enctype}' ";
}

function cid($id = null, $class = null){
	if(!empty($id)){
		$this->classid = "id='{$id}'";
	}	
	if(!empty($class)){
		$this->classid .= "class='{$class}'";
	}
	return $this;
}


function start(){
	$this->attrib['start'] .= "{$this->classid}>\r\n";
	$this->classid = null;
	return $this->attrib['start'];
}

function stop(){
	return "</form>\r\n";
}

function text($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='text' name='{$name}' value='{$value}' {$this->classid}/>";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function password($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='password' name='{$name}' value='{$value}' {$this->classid}/>\r\n";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function hidden($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='hidden' name='{$name}' value='{$value}' {$this->classid}/>\r\n";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function submit($name,$value='submit'){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='submit' name='{$name}' value='{$value}' {$this->classid}/>\r\n";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function reset($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='reset' name='{$name}' value='{$value}' {$this->classid}/>\r\n";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function file($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<input type='file' name='{$name}' value='{$value}' {$this->classid}/>\r\n";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function textarea($name,$value=null){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	$this->attrib['input'][$name]['attrib'] = "<textarea name='{$name}' >{$value}</texarea>";
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function radio($name,$value=null,$selected=false){
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	if($selected !== false){
		$checked = "checked='checked'";
	}
	$this->attrib['input'][$name]['attrib'] = "<input type='radio' name='{$name}' value='{$value}' {$this->classid} {$checked}/>\r\n";	
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function checkbox($name,$value=null,$selected=false){
	$checked = null;
	$this->attrib['input'][$name]['name'] = $name;
	$this->attrib['input'][$name]['value'] = $value;
	if($selected){
		$checked = "checked='checked'";
	}
	$this->attrib['input'][$name]['attrib'] = "<input type='checkbox' name='{$name}' value='{$value}' {$this->classid} {$checked}/>";	
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

function select($name,$value,$selected=null, $multiple=false, $size = null){
	$checked = null; $many = null;
	$this->attrib['input'][$name]['name'] = $name;
	if($multiple){
		$many = "multiple='multiple'";
	}
	if($size > 1){
		$size = "size='{$size}'";
	}
	$this->attrib['input'][$name]['attrib'] = "<select name='{$name}' {$this->classid} {$many} {$size}>\r\n";
	foreach($value as $i => $v){
	$this->attrib['input'][$name]['value'][$i] = $v;
	if($selected == $i){
		$checked = "selected='selected'";
	}
	$this->attrib['input'][$name]['attrib'] .= "<option value='{$i}' {$checked}>{$v}</option>\r\n";	
	}
	$this->attrib['input'][$name]['attrib'] .= "</select>\r\n";	
	$this->classid = null;
	return $this->attrib['input'][$name]['attrib'];
}

}

function get($name, $value=null){
	if(isset($_GET[$name])){
		return $_GET[$name];
	}
	return $value;
}


function post($name, $value=null){
	if(isset($_POST[$name])){
		return $_POST[$name];
	}
	return $value;
}

?>