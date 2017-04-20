<?php
require_once 'engine/lib/strings.php';
include_once 'my/defines.php';
$email = @$_POST['email'];
if(isset($_POST['submit'])) {
    if(!strings_isemail($email) || $email != ADMIN_EMAIL ){
		$error = 'Invalid email. Try again';
    } else if ($email == ADMIN_EMAIL) {
        $message = 'Your password in Guestbook: '.ADMIN_PASS.'';
        $from = 'Guestbook';
       $to = ADMIN_EMAIL;
       $subject = "Your password in Guestbook";
       $subject = "=?utf-8?B?".base64_encode($subject)."?=";
       $headers = "From: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
       mail($to, $subject, $message, $headers);
       $error = "Successful";
    }
}
?>
<link rel="stylesheet" href="../css/style.css">
  <?php
echo '<div class="container">
	<section class="content"><form action="" method=post>
   <h1 translatable>lost_email_lan</h1>
    <input type="text" placeholder="lost_email_lan" name="email" translatable>
 <input type="submit" name="submit" value="send_lan" translatable>
  <div class="err">'.$error.'</div>
   <a href="login.php" translatable>cansel_lan</a>
</form>';
?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/main.js"></script>

