<?php
function gb_add($name, $email, $www, $message, $captcha, &$error)
{
	$error = '';
if($captcha != $_SESSION['captcha']['code']) {
		$error['captcha'] = 'Write bets from image';
		};
	if(empty($name)) {
		$error['name'] = 'Name required';
	}
	if(empty($message)) {
		$error['message'] = 'Message required';
	};
	if(empty($email) && !strings_isemail($email)) {
		$error['email'] = 'Invalid email';
	};
	if(!$error)
	{
		$name = strings_clear($name);
	//	$message = strings_clear($message);
		$name = strings_stripstring($name, 15, 100);
		$email = strings_stripstring($email, 100, 100);
		$www = strings_stripstring($www, 100, 100);
		//$message = strings_stripstring($message, 100, 2000);
		$message = nl2br($message);
		$ip = $_SERVER["SERVER_ADDR"];
	$browser = $_SERVER["HTTP_USER_AGENT"];
  if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
  elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
  elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
  elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
  elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
  else $browser = "Unknown";
		if(!empty($www) && 'http://' != substr($www, 0, 7)) {
			$www = 'http://'.$www;
		}
		if($_FILES['image']['name']) {
			 $img_name = $_FILES['image']['name'];
    $image = 'img/'.$img_name;
    file_put_contents($image, file_get_contents($_FILES['image']['tmp_name']));
		};
		db_query_ex('INSERT INTO gb (name, email, www, message, ip, browser, img, datetime) VALUES(?, ?, ?, ?, ?, ?, ?, NOW())', $name, $email, $www, $message, $ip, $browser, $image);
		header('Location: '.PATH."?page=1");
	}
}
function gb_delete($id)
{
  db_query_ex('DELETE FROM gb WHERE id = ?', $id);
  header('Location: '.PATH."?page=1"); 
}


function gb_block($ip){
db_query_ex('INSERT INTO guestbook (ip) VALUES(?)',$ip);
 header('Location: '.PATH."?page=1"); 	
}

function gb_show($page)
{
	$begin = ($page - 1) * 4;
	
	if($_GET['order'] == 'name') {
		if($_GET['dir'] == 'down') {
	$result = db_query('SELECT * FROM gb ORDER BY name DESC LIMIT '.$begin.', '.RECSPERPAGE);
	} else {
		$result = db_query('SELECT * FROM gb ORDER BY name ASC LIMIT '.$begin.', '.RECSPERPAGE);
	} 
	} else if($_GET['order'] == 'email') {
		if($_GET['dir'] == 'down') {
	$result = db_query('SELECT * FROM gb ORDER BY email DESC LIMIT '.$begin.', '.RECSPERPAGE);
	} else {
		$result = db_query('SELECT * FROM gb ORDER BY email ASC LIMIT '.$begin.', '.RECSPERPAGE);
	}
	} else if($_GET['order'] == 'date') {
		if($_GET['dir'] == 'down') {
	$result = db_query('SELECT * FROM gb ORDER BY datetime DESC LIMIT '.$begin.', '.RECSPERPAGE);
	} else {
		$result = db_query('SELECT * FROM gb ORDER BY datetime ASC LIMIT '.$begin.', '.RECSPERPAGE);
	}
	} else {
			$result = db_query('SELECT * FROM gb ORDER BY datetime DESC LIMIT '.$begin.', '.RECSPERPAGE);
	}
	




	$out = '';
	while($row = mysqli_fetch_array($result))
		$out .= template_show_body($row['id'], $row['name'], $row['email'], $row['www'], htmlspecialchars_decode($row['message']), $row['datetime'], $row['img'], $row['ip']);
	mysqli_free_result($result);
	echo $out;
};

function gb_showpages($current)
{
	$result = db_query('SELECT * FROM gb');
	$rows = mysqli_num_rows($result);
	if($rows)
	{
		$pages = ceil($rows / RECSPERPAGE);
		echo '<div class=c>';
		for($i = 1; $i <= $pages; $i++)
		{
			if($i != $current)
				echo ' | <a href='.PATH.'?page='.$i.'>'.$i.'</a>';
			else
				echo ' | '.$i;
		}

		echo ' |';
		if($current < $pages)
			echo ' <a href='.PATH.'?page='.($current + 1).' translatable>next_lan</a>';
		echo '</div>';
	}
}

function sortArr(){
  echo '<div class="sort"><span translatable>sort_lan</span>
  <a href="'.PATH.'?order=name&dir='.($_GET['dir'] === 'up' ? 'down' : 'up').'" translatable>sort_name_lan</a>
  <a href="'.PATH.'?order=email&dir='.($_GET['dir'] === 'up' ? 'down' : 'up').'" translatable>sort_email_lan</a>
  <a href="'.PATH.'?order=date&dir='.($_GET['dir'] === 'up' ? 'down' : 'up').'" translatable>sort_date_lan</a></div>';
}

?>