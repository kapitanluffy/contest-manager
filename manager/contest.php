<?php 
include 'header.php';
include 'contest_.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
  <head>
	<?php include 'includes/head.html'; ?>
  </head>
  <body>
  <div id='wrap'>
  <div id='menu'><?php include 'includes/menu.php'; ?></div>
  
  	<div id='list'>
	<table>
<?php
foreach($contestList as $i){
echo "<tr><td>$i[name]</td> <td><a href='?".parse_get("do=edit&id=$i[id]",array('contestant','criteria'))."'>Edit</a> 
<a href='?".parse_get("do=delete&id=$i[id]",array('contestant','criteria'))."'>Delete</a></td></tr>";
}
?>
	</table>
	</div>
  
	<div id='msgs'>
		<span class='msg'><?php say($msg); ?></span>
		<span class='msg'><?php say($error); ?></span>
	</div>
	
	<div id='form'>
<?php 
echo "$form[start] $form[id] $form[name] $form[go]";
echo "<select name='postContest'>";
echo "<option value=''>connect to...</option>";
foreach($contestList as $contestValue){
$selected = '';
if($contestValue['id'] == $post_id){ $selected = "selected=selected"; }
echo "<option value='$contestValue[id]' $selected>$contestValue[name]</option>";
}
echo "</select>";
echo " Top ".$form['top'];
echo $form['judges']." Judges";
echo "<div id='select_criterias'><table>";
$selected = false;
foreach($c1 as $index => $c){
	$selected = @(in_array($c['name'],array_keys($criterias_selected))) ? true : false;
	echo "<tr>
	<td>". $contest->checkbox("criterias[$c[name]]","$c[percentage]",$selected) . "</td>
	<td class='spread'>$c[name]</td>
	<td>$c[percentage]%</td>
	<td>
	<a href='criteria.php?do=edit&id=$c[id]'>Edit</a> 
	<a href='criteria.php?do=delete&id=$c[id]'>Delete</a>
	</td>
	<tr>\r\n";
}
echo "<tfoot><td colspan='4'>
".$p1->prev_btn(parse_get('',array('contestant','id','do')))." 
".$p1->curr_btn(parse_get('',array('contestant','id','do')))."
".$p1->next_btn(parse_get('',array('contestant','id','do')))."
</td></tfoot>";
echo "</table></div>";

echo "<div id='select_contestants'><table>";
$selected = false;
foreach($c2 as $index => $c){
	$selected = @(in_array($c['id'],$contestants_selected)) ? true : false;
	echo "<tr><td>". $contest->checkbox('contestants[]',$c['id'],$selected) . "</td>
	<td>#$c[number]</td>
	<td class='spread'>$c[name]</td>
	<td>
	<a href='contestant.php?do=edit&id=$c[id]'>Edit</a> 
	<a href='contestant.php?do=delete&id=$c[id]'>Delete</a>
	</td>
	</tr>\r\n";
}
echo "<tfoot><td colspan='4'>
".$p2->prev_btn(parse_get('',array('criteria','id','do')))." 
".$p2->curr_btn(parse_get('',array('criteria','id','do')))."
".$p2->next_btn(parse_get('',array('criteria','id','do')))."
</td></tfoot>";
echo "</table></div>";
echo "$form[stop]";
?>
	</div>
	
	</div>
  </body>
</html>
