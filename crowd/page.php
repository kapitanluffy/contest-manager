<?php 

class page {

	public $get = array('resource'=>'','prev'=>'','curr'=>'','next'=>'');
	public $curr_btn = '';
	public $prev_btn = '';
	public $next_btn = '';
	public $handle = '';
	public $total_rows = '';
	
	function __construct($condition, $table, $handle='p', $limit=10){
		$this->handle = $handle;
		$result = mysql_query("select * from $table $condition");
		$total_rows = mysql_num_rows($result);
		$this->total_rows = ceil($total_rows / $limit);
		if(isset($_REQUEST[$handle]) && !empty($_REQUEST[$handle])){
			$page = $_REQUEST[$handle];
			$start = $limit * $page;
		} else {
			$start = 0;
			$page = 0;
		}
		
		$this->get['resource'] = mysql_query("select * from $table $condition limit $start,$limit");

		$prevp = $page-1;
		if($prevp >= 0){
			$this->get['prev'] = $prevp;
		}

		$this->get['curr'] = $page;
		
		$nextp = $page+1;
		if($nextp < $this->total_rows){
			$this->get['next'] = $nextp;
		}
	}

	function next_btn($link = null, $label = "&raquo;"){
		empty($link) ? $link = $this->handle . "=" . $this->get['next'] : $link .= $this->handle . "=" . $this->get['next'];
		if($this->get['next'] <= $this->total_rows  && is_int($this->get['next'])){
			return $this->next_btn = "<a href='?".$link."'>".$label."</a>";
		}
	}
	
	function curr_btn($link = null){
		empty($link) ? $link = $this->handle . "=" . $this->get['curr'] : $link .= $this->handle . "=" . $this->get['curr'];
		return $this->curr_btn = "<a href='?".$link."'>".($this->get['curr']+1)."</a>";
	}

	function prev_btn($link = null, $label = "&laquo;"){
		empty($link) ? $link = $this->handle . "=" . $this->get['prev'] : $link .= $this->handle . "=" . $this->get['prev'];
		if($this->get['prev'] >= 0 && is_int($this->get['prev'])){
			return $this->prev_btn = "<a href='?".$link."'>".$label."</a>";
		}
	}
}

?>