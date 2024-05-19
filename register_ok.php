<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./ChkScreen.php";
include_once "./head-tag.php";
include "./mysql_conn.php";
$User_ID = $conn -> real_escape_string($_POST['regi_Id']);
$User_PW = $conn -> real_escape_string(password_hash($_POST['regi_Pw'], PASSWORD_DEFAULT));
$User_NAME = $conn -> real_escape_string($_POST['regi_Name']);
$User_Email = $conn -> real_escape_string($_POST['regi_Email']);
if ($_POST['regi_Id'] == "" || $_POST['regi_Pw'] == "" || $_POST['regi_Name'] == "" || $_POST['regi_Email'] == "") {
    echo "<script>alert(\"모든 입력칸을 다 채워주세요.\"); history.back();</script>";
}else {
    $sql = "INSERT INTO USER (`id`,`pw`,`name`,`email`) VALUES ('$User_ID','$User_PW','$User_NAME','$User_Email');";
    mysqli_query($conn, $sql);
    echo "<script>alert(\"회원가입이 완료되었습니다. 로그인 페이지로 이동합니다.\"); location.href='./login.php'</script>";
}
include "./mysql_close.php";
?>

