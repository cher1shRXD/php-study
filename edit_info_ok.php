<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./ChkScreen.php";
include_once "./head-tag.php";
include "./mysql_conn.php";
@session_start();
$now_id = $_SESSION['userid'];
$new_id = $_POST['new_id'];
$new_pw = $conn -> real_escape_string(password_hash($_POST['new_pw'], PASSWORD_DEFAULT));
$retype_pw = $conn -> real_escape_string(password_hash($_POST['retype_pw'], PASSWORD_DEFAULT));
$cert_pw = $conn -> real_escape_string(password_hash($_POST['certify_pw'], PASSWORD_DEFAULT));
$sql = "SELECT * FROM USER WHERE id='$now_id'";
$result = mysqli_query($conn,$sql);
while ($row=mysqli_fetch_array($result)) {
    $now_pw = $row['pw'];
    if($_POST['new_id'] == "" && $_POST['new_pw'] == "") {
        echo "<script>alert('변경사항이 없습니다.'); location.href='./profile_Page.php';</script>";
    }else{ 
        if(password_verify($_POST['certify_pw'], $now_pw)) {
            if($_POST['new_pw'] == $_POST['retype_pw']) {
                $update_sql = "UPDATE USER SET `pw` = '$new_pw' , `id` = '$new_id' where `id` = '$now_id';";
                mysqli_query($conn, $update_sql);
                $writer_sql = "UPDATE BOARD SET `writer` = '$new_id' WHERE `writer` = '$now_id';";
                mysqli_query($conn, $writer_sql);
                echo "<script>alert('정보가 변경되었습니다. 다시 로그인 해주세요.'); location.href='./logout.php';</script>";
            }else{
                echo "<script>alert('새로운 비밀번호를 확인하세요.'); history.back();</script>";
            }
        }else{
            echo "<script>alert('현재 비밀번호가 틀립니다.'); history.back();</script>";
        }
    }
}
include "./mysql_close.php";
?>