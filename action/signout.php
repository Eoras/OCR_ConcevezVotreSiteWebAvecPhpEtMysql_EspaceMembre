<?php
session_start();
unset($_SESSION['auth']);
session_destroy();
foreach ($_COOKIE['auth'] as $key => $value )
{
    setcookie("auth[".$key."]", '', time()-3600, '/' );
}
session_start();
$_SESSION['alert'] = ['type' => "warning",
    'title' => "Sign out !",
    'message' => "You signed out successfully. Cya !"];
header("location: /index.php");
exit();