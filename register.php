<!DOCTYPE html>
<html lang="ko">
<?php include "./ChkScreen.php"; ?>
<head>
    <?php include "./head-tag.php"; ?>
</head>
<body onselectstart='return false' ondragstart='return false'>
    <div id="screen">
        <?php include "./controller.php"; ?>
        <script>
            <?php include_once "../js/css_control.js"; ?>
        </script>
        <div id="canvas">
            <?php include "../main/header.php"; ?>
            <!-- 메인화면 -->
            <div id="register_form">
                <form action="./register_ok.php" method="POST">
                    <p>Welcome to our land!
                            <br>SSUL.IN
                        </p>
                    <div>
                        <label for="regi_Id">아이디</label>
                        <input type="text" name="regi_Id" id="regi_Id" placeholder="아이디(10자 이내)" maxlength="10">
                        <label for="regi_Pw">비밀번호</label>
                        <input type="password" name="regi_Pw" id="regi_Pw" placeholder="비밀번호(6~20자이내)" maxlength="20" minlength="6">
                        <label for="regi_Name">이름</label>
                        <input type="text" name="regi_Name" id="regi_Name" placeholder="실명" maxlength="5">
                        <label for="regi_Email">이메일</label>
                        <input type="text" name="regi_Email" id="regi_Email" placeholder="이메일" maxlength="40">
                        <button type="submit" class="btn btn-secondary">Register</button>
                        <a href="./login.php">이미 가입하신 상태인가요?</a>
                    </div>
                </form>
                
            </div>
            <?php include "../main/footer.php"; ?>
        </div>
    </div>
    
    <script>
        <?php include "./control_js.js"; ?>
    </script>
</body>

</html>

