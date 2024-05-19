<?php 
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./mysql_conn.php";
$commented_post = $_POST['commented_post'];
$main_cont = $conn -> real_escape_string($_POST['main_cont']);
$comment_writer = $_POST['writer'];
$current_time = $_POST['current_time'];
$get_post_writer = mysqli_query($conn, "SELECT * FROM BOARD WHERE `post_id` = '{$commented_post}';");
while($writer_row=mysqli_fetch_array($get_post_writer)) {
    $post_owner = $writer_row['writer'];
    $commented_post_title = $writer_row['post_title'];
}
mysqli_query($conn, "INSERT INTO `COMMENT`(`post_id`,`comment_writer`,`comment_content`,comment_time) VALUES ('{$commented_post}','{$comment_writer}','{$main_cont}','{$current_time}');");
if($comment_writer != $post_owner) {
    mysqli_query($conn, "INSERT INTO NOTICE (`recipient`,`type`,`content`,`noti_time`,`is_read`) VALUES ('$post_owner','COMMENT','{$comment_writer}님이 \'{$commented_post_title}\'글에 댓글을 남겼습니다: {$main_cont}',NOW(),'no');");
}
// mysqli_query($conn, "UPDATE NOTICE SET `is_read` = '{$check_read}' WHERE `recipient` = '{$recipter}';");
include_once "./mysql_close.php";
?>