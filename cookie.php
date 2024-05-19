<?php 
error_reporting(E_ALL);
ini_set("display_errors",1);
include "./mysql_conn.php";
$stored_cookie_name = $_COOKIE['login_cookie'];
if(isset($_COOKIE['login_cookie'])) {
    $get_auto_login = "SELECT * FROM USER WHERE `login_tk`='$stored_cookie_name';"
    $auto_login_result = mysqli_query($conn, $get_auto_login);
    while($auto_login_row = mysqli_fetch_array($auto_login_result)) {
        @session_start()
        $_SESSION['userid'] = $auto_login_row["id"];
        $_SESSION['userpw'] = $auto_login_row["pw"];
        $_SESSION['follower_num'] = $auto_login_row['follower_num'];
        $_SESSION['following_num'] = $auto_login_row['following_num'];
    }
}else{
    echo "<script>alert('자동로그인 실패');</script>";
}
include "./mysql_close.php";
?>