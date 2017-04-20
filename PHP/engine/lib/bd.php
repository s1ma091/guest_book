<?php
function db_connect($host, $user, $passwd, $dbname)
{
	$link = mysqli_connect($host, $user, $passwd, $dbname) or die('Could not connect to database');
	return $link;
}

function db_query($query)
{
	$link = mysqli_connect('localhost', 'root', '', 'test');
	$result = mysqli_query($link, $query)
	  or die('Bad database query');
	return $result;
}

function db_query_ex($query)
{
	$values = func_get_args();
	array_shift($values);
	$i = 0;
	return db_query(preg_replace('%\?%e', '"\'".addslashes($values[$i++])."\'"', $query));
}
?>