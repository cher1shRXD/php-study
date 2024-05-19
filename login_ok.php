<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include_once "./ChkScreen.php";
include_once "./head-tag.php";
include "./mysql_conn.php";

$login_id = $conn -> real_escape_string($_POST['login_Id']);
$login_pw = $conn -> real_escape_string($_POST['login_Pw']);
$token = uniqid();
$auto_login = !empty($_POST['stayL_in']);
$hash_cookie = hash('sha256', 'loginCookie');
// if(!isset($_COOKIE["login_cookie"])) {    
    if($login_id == "" || $login_pw == ""){
        echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
    }else{
        $sql = "SELECT * FROM USER WHERE id='$login_id';";
        $result = mysqli_query($conn,$sql);
        $check_exists = mysqli_num_rows($result);
        if($check_exists > 0) {
            while ($row=mysqli_fetch_array($result)) {
                $hash_pw = $row['pw'];
                if(password_verify($login_pw, $hash_pw)){
                    @session_start();
                    $_SESSION['userid'] = $row["id"];
                    $_SESSION['userpw'] = $row["pw"];
                    $_SESSION['follower_num'] = $row['follower_num'];
                    $_SESSION['following_num'] = $row['following_num'];
                    if(isset($_SESSION['userid'])){
                        if($auto_login) {
                            $update_tk = "UPDATE USER SET `login_tk`= '$token' WHERE `id` = '$login_id';";
                            mysqli_query($conn, $update_tk);
                            $get_token = "SELECT * FROM USER WHERE `id`='$login_id';";
                            $token_result = mysqli_query($conn, $get_token);
                            while ($token_row = mysqli_fetch_array($token_result)) {
                                $stored_tk = $token_row['login_tk'];
                                setcookie("login_cookie" , $stored_tk , time()+(86400*60) , "/");
                            }
                            echo "<script>alert('사용자이름: {$_SESSION['userid']} 로그인 되었습니다.(자동로그인)');</script>";
                            echo "<script>location.href='./index.php';</script>";
                        }else{
                            echo "<script>alert('사용자이름: {$_SESSION['userid']} 로그인 되었습니다.');</script>";
                            echo "<script>location.href='./index.php';</script>";
                        }
                    }else{
                        echo "<script>alert('세션 생성 실패'); history.back();</script>";
                    }
                }else{ 
                    echo "<script>alert('비밀번호가 틀립니다.'); history.back();</script>";
                }
            } 
        }else{
            echo "<script>alert('존재하지 않는 회원입니다.'); history.back();</script>";
        }
    }
    
include "./mysql_close.php"
?>
