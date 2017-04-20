<?php

require_once 'engine/gb.php';
function template_header($page)
{
?><html>
<head>
<title>page <?=$page?> &lt; Guestbook</title>
<link rel="SHORTCUT ICON" href="img/icon.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
<div class='head'>
<div class='title'><h1 translatable>title_lan</h1></div>
<?php
if(!$_COOKIE['admin']){
echo "<div class='auth'><a href='login.php'translatable>log_lan</a></div>";
} else {
  echo "<div class='auth'><a href=".PATH."?logout=1' translatable>log_out</a></div>";
}
}

function template_form($name, $email, $www, $message, $captcha, $error)
{
  function error($error)
  {
    if($error) echo '<br><font color=red>'.$error.'</font>';
  }
  echo '<div class="lang"><a href='.PATH.'?en=1><button name="en"></button></a><a href='.PATH.'?ua=1><button  name="ua"></button></a>
  </form><br><br></div></div>
  <h2 translatable>new_lan</h2>
<table cellspacing="2" cellpadding="2" border="0"><form action='.PATH.'?add=1 enctype="multipart/form-data" id=form method=post><tr>
<td translatable>name_lan</td>
<td><input type=text name="name" size=30 maxlength=20 value="'.$name.'"><span id=name></span>';
  @error($error['name']);
  echo '</td>
</tr><tr>
<td translatable>email_lan</td>
<td><input type=text name="email" size=30 maxlength=100 value="'.$email.'"><span id=email></span>';
  @error($error['email']);
  echo '</td>
</tr><tr>
<td translatable>url_lan</td>
<td><input type=text name="www" size=30 maxlength=200 value="'.$www.'">';
  echo '</td>
</tr><tr>
<td translatable>message_lan</td>
<td><textarea cols=40 rows=5 name="message">'.$message.'</textarea>
<div class="message" contenteditable="true"></div>
<span id=message></span>';
  @error($error['message']);
  echo '<div class="tags">
 <span class="link" translatable>link</span>
 <span class="italic" translatable>italic</span>
 <span class="strike" translatable>strike</span>
 <span class="strong" translatable>strong</span>
</div><tr>
<td>&nbsp;</td>
<td><input type=file name="image"></td></tr>
<tr><td> <img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code"></td>
<td> <input type=text name="captcha" size=5 maxlength=5 ><span id=captcha></span>';
@error($error['captcha']);
 echo '</td></tr>
<tr><td>&nbsp;</td>
<td><input name="sb" type=submit value="add_lan" translatable></td>
</form></tr>
</table>';
}

function template_show_body($id, $name, $email, $www, $message, $datetime, $image, $ip)
{
  $out = '<div class=info><div class=cn><b>'.$name.'</b> ';
  if($email || $www)
  {
    $out .= '( ';
    if($email)
      $out .= ' <a href=mailto:'.$email.'>'.$email.'</a>';
    if($email && $www)
      $out .= ' | ';
    if($www)
      $out .= ' <a href='.$www.'>'.$www.'</a>';
    $out .= ' )';
  }
  $out .= ' <span translatable>write_lan</span> '.$datetime.'</div><div>'.$message.'</div>';
  if($image) {
  $out .= '<img class="image" src="'.$image.'"/></div>';
  } else {
    $out .= '</div>';
  }

  if(auth_is_admin())
  {
    $out .= '<div class="del">[ <a href='.PATH.'?admin=1&del='.$id.' translatable>delete_lan</a> ]</div>';
    $out .= '<div class="del">[ <a href='.PATH.'?admin=1&block='.$ip.' translatable>block_lan</a> ]</div>';
  }
  return $out;
};

?>
