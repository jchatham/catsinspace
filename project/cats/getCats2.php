<?php
session_set_cookie_params(60*60*24);//60*60*24 one month
session_start();
require ("../db.php");

$mysqli = new mysqli($host,$uname,$pass,$dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
mysqli_set_charset($mysqli, "utf8");


$sql = "SELECT imageinfo.id, imageinfo.tags, imageinfo.serverid, imageinfo.farmid, imageinfo.secret, imageinfo.owner, imageinfo.description, count(voting.upvote), voting.sessionid
FROM imageinfo
LEFT JOIN voting
ON (imageinfo.id = voting.id)
where  (imageinfo.id NOT IN (select voting.id from voting WHERE voting.sessionid LIKE '%".session_id()."%' ))
GROUP BY imageinfo.id
ORDER BY count(voting.upvote) desc
LIMIT 0, 25";

$result = $mysqli->query($sql);
$array = array();
while($row = $result->fetch_assoc())
{
   $array[] = $row;
}

echo(json_encode($array));
//echo(json_last_error());
?>