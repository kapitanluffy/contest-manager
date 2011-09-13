<?php 
include 'header.php';
include 'contestant_.php';
include 'criteria_.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
  <head>
	<?php include 'includes/head.html'; ?>
	<style>
		.wiki {
			font-family: arial, calibri;
			font-size: 1.3em;
			margin: 20px 0px;
			padding: 20px;
			border: dashed 1px gray;
		}
		.wiki ol {
			list-style-type: decimal;
			list-style-position: inside;
		}
		.wiki ol li {
			margin: 5px 0px;
		}
		.wiki h1 {
			font-size: 1.5em;
			font-weight: bold;
		}
	</style>
  </head>
  <body>
	<div id='wrap'>
	<div id='menu'><?php include 'includes/menu.php'; ?></div>

  	<div id='msgs'>
		<span class='msg'><?php say($msg); ?></span>
		<span class='msg'><?php say($error); ?></span>
	</div>
	
	<?php include 'includes/body.html'; ?>
	</div>
</div>
  </body>
</html>
