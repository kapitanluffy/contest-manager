<?php
include 'header.php';
if(!$loggedin){header('Location: judge.php');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<title></title>
<style>
@import url(assets/style.css);
</style>
</head>
<body>
<?php include 'navi.php'; ?>
<ul id='contestsList'>
<?php foreach($contests as $contest){
echo "<li><a href='contest.php?id=$contest[id]'>".ucwords($contest['name'])."</a></li>";
} ?>
</ul>
<div id='msg'><?php echo $msg; ?></div>
</body>
</html>
