<!DOCTYPE html>
<html lang="ko">
<?php include "./ChkScreen.php"; ?>
<head>
    <?php include "./head-tag.php"; ?>
</head>
<body onselectstart='return false' ondragstart='return false'>
    <div id="screen">
        <script>
            <?php include_once "../js/css_control.js"; ?>
        </script>
        <?php include "./controller.php"; ?>
        <div id="canvas">
            <?php include "../main/header.php"; ?>
            <!-- 메인화면 -->
            <?php
            if(isset($_SESSION['userid'])) {        
                echo 
                "<div id=\"edit_form\">    
                    <form action=\"edit_info_ok.php \" method=\"POST\">
                        <p class=\"KR_font\">회원정보 변경</p>
                        <div id=\"new_info_area\">
                            <input type=\"text\" placeholder=\"새로운 아이디를 입력해주세요.\" id=\"new_id\" name=\"new_id\" class=\"KR_font\">
                            <input type=\"password\" placeholder=\"새로운 비밀번호를 입력해주세요.\" id=\"new_pw\" name=\"new_pw\" class=\"KR_font\">
                            <input type=\"password\" placeholder=\"비밀번호 확인\" id=\"retype_pw\" name=\"retype_pw\" class=\"KR_font\">
                        </div>
                        <div id=\"certify_user_area\">
                            <input type=\"password\" placeholder=\"현재 비밀번호를 입력하세요.\" id=\"certify_pw\" name=\"certify_pw\" class=\"KR_font\">
                        </div>
                        <button type=\"submit\" id=\"update_info\" class=\"btn btn-secondary\">변경사항 저장</button>
                    </form>
                </div>";
            }else{
                echo "<script>location.href='./login.php';</script>";
            }
            ?>
            
            <?php include "../main/footer.php"; ?>
        </div>
    </div>
    
    <script>
        <?php include "./control_js.js"; ?>
    </script>
</body>

</html>
