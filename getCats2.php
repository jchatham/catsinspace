<?php
session_set_cookie_params(31536000);//60*60*24*365 one year
session_start();
require ("../db.php");



$mysqli = new mysqli($host,$uname,$pass,$dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mysqli_set_charset($mysqli, "utf8");
//$sql = "SELECT imageinfo.id, imageinfo.tags, imageinfo.usertags, imageinfo.serverid, imageinfo.farmid, imageinfo.secret, imageinfo.owner, imageinfo.description
//FROM imageinfo
//WHERE imageinfo.id NOT IN (select voting.id from voting where voting.sessionid like '%".session_id()."%') LIMIT 0, 25;";

$sql = "SELECT imageinfo.id, imageinfo.tags, imageinfo.usertags, imageinfo.serverid, imageinfo.farmid, imageinfo.secret, imageinfo.owner, imageinfo.description, voting.upvote, voting.sessionid
FROM imageinfo
LEFT JOIN voting
ON (imageinfo.id = voting.id)
WHERE (voting.sessionid NOT LIKE '%".session_id()."%' || voting.sessionid IS NULL)
ORDER BY voting.upvote
LIMIT 0, 25";

$result = $mysqli->query($sql);
$array = array();
while($row = $result->fetch_assoc())
{
   $array[] = $row;
}
//var_dump($array);
echo(json_encode($array));
//echo(json_last_error());
?>