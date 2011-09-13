<?php
include 'header.php';
($loggedin) ? header('Location: admin.php') : '';
if(post('submit')){
	foreach($_POST as $name => $value){
		if(empty($value)){
			$error = ucfirst($name) . " is required"; break;
		}
	}
	if(empty($error)){
		$select = $db->select('managers',"WHERE username='$_POST[username]' AND password='$_POST[password]'")or die(mysql_error());
		if($db->rows_affected() == 1){
			$user = mysql_fetch_assoc($select);
			$_SESSION['id'] = $user['id'];
			$_SESSION['user'] = $user['username'];
			header('Location: admin.php?m=loggedin');
		}
	}
}

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
  <form name='login' method='post'>
  Username: <input type='text' name='username' value='<?php echo post('username'); ?>' />
  Password: <input type='password' name='password' value='<?php echo post('password'); ?>' />
  <input type='submit' name='submit' value='login'/>
  </form>
  <div class='error'><?php say($error); ?></div>
  </body>
</html>
