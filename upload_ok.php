<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./ChkScreen.php";
include_once "./head-tag.php";
include_once "./mysql_conn.php";

@session_start();
$writer_id = $_SESSION['userid'];
$allowed_ext = array('jpg','jpeg','png','gif','mp4','mpeg','avi');
$content_title = $conn -> real_escape_string($_POST['title']);
$content_main = $conn -> real_escape_string($_POST['content']);
$content_picture = $conn -> real_escape_string($_FILES['contentPic']['name']);
$tmp_content_picture = $conn -> real_escape_string($_FILES['contentPic']['tmp_name']);
$file_size = $conn -> real_escape_string($_FILES['contentPic']['size']);
$error = $_FILES['contentPic']['error'];
if(isset($_SESSION['userid'])) {
    if($_POST['title'] == "") {
        echo "<script>alert(\"제목을 입력해주세요.\"); history.back();</script>";
    }else{
        if($_POST['content'] == "") {
            echo "<script>alert(\"본문을 입력해주세요.\"); history.back();</script>";
        }else{
            if(empty($content_picture)) {
                $sql = "INSERT INTO BOARD (`post_title`,`writer`,`write_date`,`post_content`,`likes_num`,`comments_num`) VALUES ('$content_title','$writer_id',NOW(),'$content_main','0','0');";
                mysqli_query($conn, $sql);
                echo "<script>alert(\"글이 등록 되었습니다.\"); location.replace('./index.php');</script>";
            }else{
                $tmp_checkExt = explode(".",$content_picture);
                $checkExt = end($tmp_checkExt);
                if(in_array($checkExt, $allowed_ext)) {
                    if($file_size > 150000000) {
                        echo "<script>alert(\"파일크기가 너무 큽니다.(150MB 이하)\"); history.back();</script>";
                    }else{
                        $sql = "INSERT INTO BOARD (`post_title`,`writer`,`write_date`,`post_content`,`likes_num`,`comments_num`,`post_picture`) VALUES ('$content_title','$writer_id',NOW(),'$content_main','0','0','$content_picture');";
                        mysqli_query($conn, $sql);
                        move_uploaded_file($tmp_content_picture, "./uploads/$content_picture");
                        echo "<script>alert(\"글이 등록 되었습니다.\"); location.replace('./index.php');</script>";
                    }
                }else{
                    echo "<script>alert(\"허용되지 않은 파일형식입니다.({$checkExt})\"); history.back();</script>";
                }
            }
        }
    }
}

include_once "./mysql_close.php";
?>