<?php
echo "here";
require ("../db.php");
//var_dump($_REQUEST);
//echo $_POST['id'];
session_start();

$mysqli = new mysqli($host,$uname,$pass,$dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
 //id: data.id, up: data.upvoted, down: data.downvoted, star: data.starred , id: imageInfo.id, secret: imageInfo.secret, serverid: imageInfo.serverid, farmid: imageInfo.farmid}
//$stmt = $mysqli->prepare("INSERT INTO `users` VALUES('', ?, ?, ?, ?, ?, ?, ?)");
//$stmt->bind_param("sssssss", $username, $fname, $email, $region, $password, $uniqueSalt, $activation);

//$sql = "insert into voting(id, upvote, downvote, description, serverid, farmid, secret, star, sessionid)\n"
//    . "values(6997307493, true, false, \' \', 7195, 8, \'c9682bc1f4\', false, \'jeff\')\n"
//    . "ON DUPLICATE KEY UPDATE upvote = true, downvote = false, star = false, description = \'\'";
$session_var = session_id();

/*
echo session_id();
$stmt = $mysqli->prepare( "insert into `voting`(id) value(?);");
$stmt->bind_param("s",$_POST['id']);
$stmt->execute();
*/
$mysqli -> report_mode = MYSQLI_REPORT_ALL;
/*
echo session_id();
$stmt = $mysqli->prepare( "INSERT INTO `voting`(upvote, downvote, id, description, serverid, farmid, secret, sessionid) VALUES(?,?,?, ?, ?, ?, ?, ?) ON DUPLICATE KEY ignore");
$stmt->bind_param("ssssssss",$_POST['up'], $_POST['down'],$_POST['id'],$_POST['description'], $_POST['serverid'],  $_POST['farmid'], $_POST['secret'], $session_var);
$stmt->execute();
*/

echo session_id();
$stmt = $mysqli->prepare( "
INSERT INTO `voting`(upvote, downvote, id, description, serverid, farmid, secret, sessionid) 
VALUES(?,?,?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE 
upvote = VALUES(upvote), 
downvote = VALUES(downvote), 
description = VALUES(description)");
$stmt->bind_param("ssssssss",$_POST['up'], $_POST['down'],$_POST['id'],$_POST['description'], $_POST['serverid'],  $_POST['farmid'], $_POST['secret'], $session_var);
echo ($stmt);
$stmt->execute();




/*
echo session_id();
$stmt = $mysqli->prepare( "insert into voting(id, upvote, downvote, description, serverid, farmid, secret, sessionid) values(?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE upvote = ?, downvote = ?, description = ?");
$stmt->bind_param($_POST['id'], $_POST['up'], $_POST['down'],$_POST['description'], $_POST['serverid'], $_POST['farmid'], $_POST['secret'], $session_var, $_POST['up'], $_POST['down'], $_POST['description']);
echo $stmt;
$stmt->execute();

/*
$stmt = $mysqli->prepare("INSERT INTO `voting` VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(session_id(), $_POST['secret'], $_POST['id'], $_POST['farmid'], $_POST['serverid'], $_POST['upvote'], $_POST['downvote'], $_POST['star']);
echo $stmt;
$stmt->execute();
*/
$stmt->close();
?>