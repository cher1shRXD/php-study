<?php 
    @session_start();
?>
<div id="controller">
    <div id="control_btn">
        <img src="./back.svg" alt="" id="back" onclick="GoBack();">
        <img src="./reload.svg" alt="" id="reload" onclick="Reloading();">
    </div>
    <?php
        if(isset($_SESSION['userid'])) {
            echo 
            "
            <div id=\"logout_btn\">
                <p class=\"KR_font\" id=\"print_id_H\">{$_SESSION['userid']}님 환영합니다.</p>
                <button onclick=\"log_out();\" id=\"logout\" class=\"btn btn-dark\">로그아웃</button>
            </div>
            ";
        }else{
            echo "<div id=\"logout_btn\"><a href=\"./login.php\" class=\"KR_font\" id=\"print_id_H\">로그인해주세요.</a></div>";
        }
    ?>
</div>