<?php
include_once "./mysql_conn.php";
error_reporting(E_ALL);
ini_set("display_errors",1);
$like_clicker = $_POST['like_clicker'];
$liked_post = $_POST['liked_post'];
$writer = $_POST['writer'];
$is_like = $_POST['check_like'];
if($is_like == 'be_like') {
    $add_like = "INSERT INTO `LIKE` (`post_id`,`liker`,`like_time`) VALUES ('$liked_post','$like_clicker',NOW());";
    mysqli_query($conn, $add_like);
    $like_post_sql = mysqli_query($conn, "SELECT * FROM `LIKE` WHERE `post_id` = '{$liked_post}';");
    $cnt_rows = mysqli_num_rows($like_post_sql);
    $update_like_num = "UPDATE BOARD SET `likes_num` = '{$cnt_rows}' WHERE `post_id` = '{$liked_post}';";
    mysqli_query($conn, $update_like_num);
    $get_post_sql = mysqli_query($conn, "SELECT * FROM `BOARD` WHERE `post_id` = '{$liked_post}';");
    if($like_clicker != $writer) {
        while($rows=mysqli_fetch_array($get_post_sql)) {
            $post_title = $rows['post_title'];
        }
        
        mysqli_query($conn, "INSERT INTO NOTICE (`recipient`,`type`,`content`,`noti_time`,`is_read`) VALUES ('$writer','LIKE','{$like_clicker}님이 다음글을 좋아합니다: {$post_title}',NOW(),'no');");
    }
        
}elseif($is_like == 'cancel_like') {
    $cancel_like = "DELETE FROM `LIKE` WHERE `post_id` = '$liked_post' AND `liker` = '$like_clicker';";
    mysqli_query($conn, $cancel_like);
    $count_sql = mysqli_query($conn, "SELECT * FROM `LIKE` WHERE `post_id` = '{$liked_post}';");
    $cnt_rows = mysqli_num_rows($count_sql);
    $update_like_num = "UPDATE BOARD SET `likes_num` = '$cnt_rows' WHERE `post_id` = '$liked_post';";
    mysqli_query($conn, $update_like_num);
}
include_once "./mysql_close.php";
?>