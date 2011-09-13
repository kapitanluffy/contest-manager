<?php
include 'header.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
  <head>
    <title></title>
	<style>
	.error { color: red; }
	</style>
  </head>
  <body>
	Choos a contest
	<?php
		echo "<ul>";
		foreach($contests as $contest){
			echo "<li>$contest[name] <a href='contest.php?".parse_get("id=$contest[id]")."'>&raquo;</a></li>";
		}
		echo "</ul>";
	?>
  </body>
</html>
