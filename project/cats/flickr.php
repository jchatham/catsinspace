<?php

require ("../db.php");

$mysqli = new mysqli($host,$uname,$pass,$dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";
require_once("phpFlickr.php");
// Create new phpFlickr object
$f = new phpFlickr("f90134fb1fe957aafff8e74c3f28908c","b20f6d84c45bbfc6",true);

mysqli_set_charset($mysqli, "utf8");
//for Goddard
$counter = 10;
while ($counter >0)
{
$tags = "crew earth observation, Crew Earth Observation, Crew Earth Observations, earth";

$photos_space = $f->photos_search(array("tags"=>$tags, "sort"=>"interestingness-desc","user_id"=>"28634332@N05", "tag_mode"=>"any", "extras"=>"owner_name, tags, description", "page"=>$counter ));
var_dump($photos_space);

foreach ((array)$photos_space['photo'] as $photo) {
//preg_replace(‘/[^\pL\pN\pP\pS\pZ\pM]/u’, ”, substr($photo[description],0,300))
$sql = "INSERT INTO `catsinsp_meow`.`imageinfo` (`id`, `serverid`, `farmid`, `secret`, `owner`, `tags`, `description`) VALUES ('".$photo[id]."', '".$photo[server]."', '".$photo[farm]."', '".$photo[secret]."', '".$photo[owner]."', '".$photo[tags]."', '".strip_tags(substr($photo[description],0,300))."');";
$mysqli->query($sql);

	echo "sql ".$sql;
	echo "";
	}
$counter--;
}


//for Marshal Space Flight Center
$counter = 10;
while ($counter >0)
{
$tags = "earth";
$photos_space = $f->photos_search(array("tags"=>$tags, "sort"=>"interestingness-desc","user_id"=>"24662369@N07", "tag_mode"=>"any", "extras"=>"owner_name, tags, description", "page"=>$counter ));

foreach ((array)$photos_space['photo'] as $photo) {
//preg_replace(‘/[^\pL\pN\pP\pS\pZ\pM]/u’, ”, substr($photo[description],0,300))
$sql = "INSERT INTO `catsinsp_meow`.`imageinfo` (`id`, `serverid`, `farmid`, `secret`, `owner`, `tags`, `description`) VALUES ('".$photo[id]."', '".$photo[server]."', '".$photo[farm]."', '".$photo[secret]."', '".$photo[owner]."', '".$photo[tags]."', '".strip_tags(substr($photo[description],0,300))."');";
$mysqli->query($sql);

	}
$counter--;
}
 

 
 echo $f->getErrorCode();
 echo $f->getErrorMsg();
 echo "done";
 
?>