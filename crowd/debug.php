<?php 

function debug(){
$data = func_get_args();
$f = "debug.txt";
$fh = fopen($f, 'w');
ob_start();
foreach($data as $d){
	print_r($d);
	echo "\r\n-----------------\r\n";
}
$data = ob_get_contents();
ob_end_clean();
fwrite($fh, "debug ".date('Y-m-d H:i:s')." \r\n");
fwrite($fh, $data);
fclose($fh);
	echo "
	<script type='text/javascript'>
		window.open('debug.txt','debug','width=400,height=300,scrollbars=yes');
	</script>
	";
}
?>