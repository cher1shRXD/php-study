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
        <div id="screen">
            <div id="canvas">
                <?php include "../main/header.php"; ?>
                <!-- 메인화면 -->
                <div id="login_form">
                    <form action="./login_ok.php" method="POST">
                        <p>Welcome to our land!
                            <br>SSUL.IN
                        </p>
                        <div>
                            <label for="login_Id">아이디</label>
                            <input type="text" placeholder="아이디를 입력하세요" name="login_Id" id="login_Id" label="login_Id">
                            <label for="login_Pw">비밀번호</label>
                            <input type="password" placeholder="비밀번호를 입력하세요" name="login_Pw" id="login_Pw" label="login_Pw">
                            <div id="check_div">
                                <input type="checkbox" id="stayL_in" name="stayL_in">    
                                <label for="stayL_in">로그인 유지</label>
                            </div>
                            <button type="submit" id="login_Btn" class="btn btn-secondary" name="login_subm">Log-In</button>
                            <a href="./register.php">회원이 아니신가요?</a>
                        </div>
                    </form>
                    
                </div>
                <?php include "../main/footer.php"; ?>
            </div>
        </div>
    </div>
    
        
    <script>
        <?php include "./control_js.js"; ?>
    </script>
</body>

</html>