<?php
include "./mysql_conn.php";
error_reporting(E_ALL);
ini_set("display_errors",1);
@session_start();
$tk_id = $_SESSION['userid'];
$delete_tk = "UPDATE USER SET `login_tk`= NULL WHERE `id` = '$tk_id';";
setcookie("login_cookie","",time()-(86400*60));
mysqli_query($conn, $delete_tk);
session_unset();
session_destroy();
echo "<script>alert(\"로그아웃되었습니다.\"); location.href=\"./index.php\"; </script>";
include "./mysql_close.php";
?>
