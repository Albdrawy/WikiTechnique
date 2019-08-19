<?php 
if (!isset($_SESSION)) { session_start(); }


if(isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['register'])) {
if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
die('already logged in');
}
try {
$db = new PDO("mysql:host=localhost;dbname=databasenameHERE", "dbusernameHERE", "dbpassHERE");
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $db->prepare('SELECT username, password, id FROM users WHERE username = ?');
if ($statement->execute(array($_POST['username']))) {
$row = $statement->fetch(PDO::FETCH_ASSOC);
if ($statement->rowCount() !== 0) { 
if (password_verify($_POST['password'], $row['password'])) {
$_SESSION['userid'] = $row['id'];
$_SESSION['username'] = $row['username'];
die("successfully logged in");
} 
else { die("wrong password"); }
} 
else { die("i couldn't find that username"); }
}

} catch(PDOException $e) { die($e->getMessage()); }
} 
elseif (isset($_POST['register']) && isset($_POST['username']) && isset($_POST['password'])) {
$db = new PDO("mysql:host=localhost;dbname=databasenameHERE", "dbusernameHERE", "dbpassHERE");
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $db->prepare('INSERT INTO users (username,password) VALUES (?,?)');
if ($statement->execute(array($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)))) {
die("you r now registred in our site");
}
else { die("i couldn't add u to the database"); }
}
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<form method="post" action="">
<input type="text" name="username"></input>
<input type="password" name="password"></input>
<br/>
<input type="submit" value="login"></input>
</form>
<br/>
<br/>
<hr/>
<form method="post" action="">
<input type="hidden" name="register" />
<input type="text" name="username"></input>
<input type="password" name="password"></input>
<br/>
<input type="submit" value="register"></input>
</form>
</body>
</html>
[/PHPCODE]
