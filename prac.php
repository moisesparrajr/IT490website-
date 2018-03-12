#!/bin/php

<?php

$mydb = new mysql()

if ($mydb->errno != 0)
{
	echo "failed to connect" . $mydb.error . PHP_EOL;
	exit(0);
}

echo "success" . PHP_EOL;

$query = "select * from student;";

$response = $mydb->query($query);


?>
