<?php 
include 'header.php';
include 'criteria_.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
  <head>
	<?php include 'includes/head.html'; ?>
  </head>
  <body>
  <div id='wrap'>
  <div id='menu'><?php include 'includes/menu.php'; ?></div>
	<div id='msgs'>
		<span class='msg'><?php say($msg); ?></span>
		<span class='msg'><?php say($error); ?></span>
	</div>
	<div id='form'>
<?php 
echo <<<FORM
$form[start]
$form[id]
$form[name]
$form[percent]%
$form[go]
$form[stop]
FORM;
?>
	</div>
	<div id='list'>
	<table>
	<tbody>
<?php
	while($i = mysql_fetch_assoc($pagi->get['resource'])){
echo <<<FORM
<tr>
<td class='spread'>$i[name] </td>
<td>$i[percentage]%</td>
<td><a href='?do=edit&id=$i[id]'>Edit</a> <a href='?do=delete&id=$i[id]'>Delete</a></td>
</tr>
FORM;
	}
?>
<?php
	echo "<tfoot><td colspan='3'>". $pagi->prev_btn() ."". $pagi->curr_btn() ."". $pagi->next_btn() ."</td></tfoot>";
?>
	</tbody>
	</table>
	</div>
	</div>
  </body>
</html>
