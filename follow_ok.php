<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./mysql_conn.php";
$follow_clicker = $_POST['follow_clicker'];
$followed_user = $_POST['followedUser'];
$is_follow = $_POST['check_follow'];
if($is_follow == 'be_follow') {
    $add_follow = "INSERT INTO FOLLOW (`followed`,`following`,`follow_time`) VALUES ('$followed_user','$follow_clicker',NOW());";
    mysqli_query($conn, $add_follow);
    $cnt_wed_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `FOLLOW` WHERE `followed` = '{$followed_user}';"));
    $cnt_wing_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `FOLLOW` WHERE `following` = '{$follow_clicker}';"));
    mysqli_query($conn, "UPDATE USER SET `follower_num` = '$cnt_wed_rows' where `id` = '{$followed_user}';");
    mysqli_query($conn, "UPDATE USER SET `following_num` = '$cnt_wing_rows' where `id` = '{$follow_clicker}';");
    mysqli_query($conn, "INSERT INTO NOTICE (`recipient`,`type`,`content`,`noti_time`,`is_read`) VALUES ('$followed_user','FOLLOW','{$follow_clicker}님이 당신을 팔로우 합니다.',NOW(),'no')");
}elseif($is_follow == 'cancel_follow') {
    $cancel_follow = "DELETE FROM `FOLLOW` WHERE `followed` = '$followed_user' AND `following` = '$follow_clicker';";
    mysqli_query($conn, $cancel_follow);
    $cnt_wed_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `FOLLOW` WHERE `followed` = '{$followed_user}';"));
    $cnt_wing_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `FOLLOW` WHERE `following` = '{$follow_clicker}';"));
    mysqli_query($conn, "UPDATE USER SET `follower_num` = '$cnt_wed_rows' where `id` = '{$followed_user}';");
    mysqli_query($conn, "UPDATE USER SET `following_num` = '$cnt_wing_rows' where `id` = '{$follow_clicker}';");
}
include_once "./mysql_close.php";
?>