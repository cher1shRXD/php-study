<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./ChkScreen.php";
include_once "./head-tag.php";
include_once "./mysql_conn.php";
@session_start();
$currentUser = $_SESSION['userid'];
$postid = $_POST['post_id'];
$sql = "UPDATE BOARD SET `available` = 0 WHERE `post_id` = '$postid' AND `writer` = '$currentUser';";
mysqli_query($conn, $sql);
echo "<script>alert('글이 성공적으로 삭제되었습니다'); location.href='./profile_Page.php';</script>";
include_once "./mysql_close.php";
?>