<?php

function strings_isemail($string)
{
	return preg_match('%[-\.\w]+@[-\w]+(?:\.[-\w]+)+%', $string);
}

function strings_addlinks($string)
{
	return preg_replace(
		'%((?:http|ftp)://[-\w]+(?:\.[-\w]+)+\b[-\w:@&?=+,!/~*$\.\'\%]*)(?<![\.,?!)])%i',
		'<a href="\\1">\\1</a>',
		$string
	);
}

function strings_clear($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	return htmlspecialchars($string, ENT_QUOTES);
}

function strings_stripstring($text, $wrap, $length)
{
	$text = preg_replace('%(\S{'.$wrap.'})%', '\\1 ', $text);
	return substr($text, 0, $length);
}
?>