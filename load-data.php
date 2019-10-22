<?php

$file = "input/query.txt";

$fn = fopen($file,"r");
$data=array(); 
while(! feof($fn))  {
	$line = fgets($fn);
	$data[] = $line;
}

fclose($fn);


$result=array(
	'content' => $data
);


$response = json_encode($result);
echo $response;
?>