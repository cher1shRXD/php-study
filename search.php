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
            <?php 
            include_once "./mysql_conn.php";
            if(isset($_SESSION['userid'])) {
                $my_name = $_SESSION['userid'];
                $get_notice = mysqli_query($conn, "SELECT * FROM NOTICE WHERE `recipient` = '$my_name' AND `is_read` = 'no';");
                $cnt_notices = mysqli_num_rows($get_notice);
            }
            ?>
            <!-- 메인화면 -->
            <div id="search_area">
                <div id="search">
                    <input type="text" placeholder="무엇이든 물어보살🤖" name="search" id="search_box" label="search_box">
                    <button type="submit" id="search_Btn" name="submit_words" class="btn btn-secondary" onclick="chatgpt(); ">검색</button>
                </div>
                <div id="chat_box">

                </div>
            </div>
            <?php include "../main/footer.php"; ?>
        </div>
        <?php 
        if(isset($_SESSION['userid'])) {
            echo
            "
            <div id=\"notice_box\">
                <div id=\"notice_close\">
                    <p class=\"KR_font\">알림창</p>
                    <img src=\"picture_del.svg\" alt=\"{$_SESSION['userid']}\" onclick=\"notice_window(this);\">
                </div>
                <div id=\"notice_cont\">
            ";
            $get_noti_cont = mysqli_query($conn, "SELECT * FROM NOTICE WHERE `recipient` = '{$_SESSION['userid']}' ORDER BY noti_time DESC;");
            while($noti_row = mysqli_fetch_array($get_noti_cont)) {
                $noti_content = $noti_row['content'];
                $noti_type = $noti_row['type'];
                $noti_time = $noti_row['noti_time'];
                $noti_id = $noti_row['noti_id'];
                if($noti_type == 'FOLLOW') {
                    $noti_type = '팔로우';
                }else{
                    $noti_type = '좋아요';
                }
                echo 
                "
                    <div class=\"noti_cont\">
                        <p class=\"noti_type\">{$noti_type}</p>
                        <p class=\"noti_main\">{$noti_content}</p>
                        <p class=\"noti_time\">{$noti_time}</p>
                        <img src=\"picture_del.svg\" class=\"del_alert\" id=\"{$noti_id}\" alt=\"{$_SESSION['userid']}\" onclick=\"del_noti(this)\">
                    </div>
                ";     
            }
            
        }
            echo 
            "
                </div>
            </div>
            ";
    ?>
    </div>
    
    <script>
        <?php include "./control_js.js"; ?>
    </script>
    <?php include_once "./mysql_close.php"; ?>
</body>

</html>
