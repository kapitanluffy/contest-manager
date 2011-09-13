<?php

class MySQL {

private $conn;
public $resource;
public $lastQuery;

function __construct($database,$pass='',$user='root',$server='localhost'){
	$this->conn = @mysql_connect($server,$user,$pass)or die('No Database Connection');
	return @mysql_select_db($database,$this->conn)or die('No Database');
}

function query($string){
	$this->resource = mysql_query($string,$this->conn);
	$this->lastQuery = $string;
	return $this->resource;
}

function select($table, $condition=null, $columns='*'){
	$query = "SELECT {$columns} FROM {$table} {$condition}";
	return $this->query($query);
}

function delete($table, $condition){
	$query = "DELETE FROM {$table} {$condition}";
	return $this->query($query);
}

function update($table, $columns = array(), $condition=null){
	$set = array();
	foreach($columns as $field => $value){
		$set[] = "{$field} = '{$value}'";
	}
	$set = implode(',',$set);
	$query = "UPDATE {$table} SET {$set} {$condition}";
	return $this->query($query);
}

function insert($table, $columns = array(), $condition=null){
	$fields = array_keys($columns);
	$values = $columns;
	$fields = implode(',',$fields);
	$values = '"'.implode('","',$values).'"';
	$query = "INSERT {$table} ({$fields}) VALUES ({$values}) {$condition}";
	return $this->query($query)or die($query.' -'.mysql_error());
}

function rows_affected($resource = null){
	$r = empty($resource) ? $this->resource : $resource;
	$count = @mysql_num_rows($r);
	if($count > 0){
		return $count;
	}
	$count = @mysql_affected_rows($r);
	if($count > 0){
		return $count;
	}
	return false;
}

function result_array($ident = null, $resource = null){
	$record = 0;
	$records = array();
	$r = empty($resource) ? $this->resource : $resource;
	while($result = @mysql_fetch_assoc($r)){
		empty($ident) ? $records[$record++] = $result : $records[$result[$ident]] = $result;
	}
	return $records;
}

function result_cell($row = 0, $field = null, $resource = null){
	$r = empty($resource) ? $this->resource : $resource;
	return mysql_result($r,$row,$field);
}

}


?>