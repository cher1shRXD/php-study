<?php
include_once "./mysql_conn.php";
error_reporting(E_ALL);
ini_set("display_errors",1);
$like_clicker = $_POST['like_clicker'];
$liked_comm = $_POST['liked_comm'];
$writer = $_POST['writer'];
$is_like = $_POST['check_like'];
if($is_like == 'be_like') {
    $add_like = "INSERT INTO `LIKE` (`comment_id`,`liker`,`like_time`) VALUES ('$liked_comm','$like_clicker',NOW());";
    mysqli_query($conn, $add_like);
    $like_comm_sql = mysqli_query($conn, "SELECT * FROM `LIKE` WHERE `comment_id` = '{$liked_comm}';");
    $cnt_rows = mysqli_num_rows($like_comm_sql);
    $update_like_num = "UPDATE `COMMENT` SET `comm_like_num` = '{$cnt_rows}' WHERE `comment_id` = '{$liked_comm}';";
    mysqli_query($conn, $update_like_num);
    $get_comm_sql = mysqli_query($conn, "SELECT * FROM `COMMENT` WHERE `comment_id` = '{$liked_comm}';");
    if($like_clicker != $writer) {
        while($rows=mysqli_fetch_array($get_comm_sql)) {
            $comm_main = $rows['comment_content'];
        }
        
        mysqli_query($conn, "INSERT INTO NOTICE (`recipient`,`type`,`content`,`noti_time`,`is_read`) VALUES ('$writer','LIKE','{$like_clicker}님이 댓글을 좋아합니다: {$comm_main}',NOW(),'no');");
    }
        
}elseif($is_like == 'cancel_like') {
    $cancel_like = "DELETE FROM `LIKE` WHERE `comment_id` = '$liked_comm' AND `liker` = '$like_clicker';";
    mysqli_query($conn, $cancel_like);
    $count_sql = mysqli_query($conn, "SELECT * FROM `LIKE` WHERE `comment_id` = '{$liked_comm}';");
    $cnt_rows = mysqli_num_rows($count_sql);
    $update_like_num = "UPDATE `COMMENT` SET `comm_like_num` = '$cnt_rows' WHERE `comment_id` = '$liked_comm';";
    mysqli_query($conn, $update_like_num);
}
include_once "./mysql_close.php";
?>