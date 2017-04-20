<?php
include_once 'my/defines.php';
$name = htmlspecialchars($_POST['uname']);
$pass = htmlspecialchars($_POST['psw']);
if(isset ($_POST['submit'])) {
 SetCookie('admin', '');
  if($name == ADMIN_NAME && $pass == ADMIN_PASS) {
  SetCookie("admin", $name);
  header("Location:index.php");
  } else {
    $error = 'Name or password is not correct. Try again';
  };
} ?>
<link rel="stylesheet" href="css/style.css">
  <?php
echo '<div class="container">
	<section class="content"><form action="login.php" id=login method=post>
   <h1 translatable>login_lan</h1>
    <input type="text" placeholder="ent_name_lan" name="uname" translatable>
    <input type="password" placeholder="ent_pass_lan" name="psw" translatable>
 <input type="submit" name="submit" value="log_lan" translatable>
 <div class="err"> '.$error.'</div>
<a href="email.php" translatable>lost_lan</a>
				<a href="index.php" translatable>cansel_lan</a>  
</form>
</section>
</div>';
?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/main.js"></script>