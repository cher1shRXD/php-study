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
            <?php 
            include_once "./mysql_conn.php";
            if(isset($_SESSION['userid'])) {
                $my_name = $_SESSION['userid'];
                $get_notice = mysqli_query($conn, "SELECT * FROM NOTICE WHERE `recipient` = '$my_name' AND `is_read` = 'no';");
                $cnt_notices = mysqli_num_rows($get_notice);
            }
            ?>
            <!-- 메인화면 -->
            
            <?php
            if(isset($_SESSION['userid'])) {
                echo 
                "
                <div id=\"making_page\">    
                    <div class=\"make_posts\" id=\"making_form\">
                        <form action=\"./upload_ok.php\" method=\"POST\" enctype=\"multipart/form-data\" onsubmit=\"return confirm('업로드 후에는 글을 수정할 수 없습니다. 계속 하시겠습니까?');\">
                            <button type=\"submit\" name=\"posting\" id=\"posting\" class=\"btn btn-secondary\">업로드</button>
                            <img src=\"./picture_del.svg\" alt=\"닫기\" id=\"delete_pic\" onclick=\"delete_picture();\">    
                            <div class=\"content-picture\">
                                <div id=\"image_container\">
                                    <input type=\"file\" name=\"contentPic\" onchange=\"setThumbnail(event);\" id=\"file\">
                                    <img src=\"./pic_up.svg\" id=\"pic_up\" onclick=\"onclick=document.getElementById('file').click();\">
                                </div>
                                <script>
                                    var file_input = document.getElementById(\"pic_up\");
                                    function setThumbnail(event) {
                                        var reader = new FileReader(); 
                                        
                                        reader.onload = function(event) {
                                            var ext = event.target.result.split('/')[0];
                                            if(ext == 'data:video') {
                                                var video = document.createElement(\"video\");
                                                video.setAttribute(\"src\", event.target.result);
                                                video.setAttribute(\"id\" , \"uploaded-video\");
                                                video.autoplay = true;
                                                video.muted = true;
                                                video.controls = true;
                                                file_input.style.display = \"none\";
                                                document.querySelector(\"div#image_container\").appendChild(video);
                                            }else{
                                                var img = document.createElement(\"img\");
                                                img.setAttribute(\"src\", event.target.result);
                                                img.setAttribute(\"id\" , \"uploaded-img\");
                                                file_input.style.display = \"none\";
                                                document.querySelector(\"div#image_container\").appendChild(img);
                                            }
                                        };

                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                    function delete_picture() {
                                        if(confirm('정말로 다시 작성하시겠습니까? 현재 작성한 내용은 복구되지 않습니다.')) {
                                            location.reload();
                                        }
                                    }  
                                </script>
                            </div>
                            <div class=\"content-words\">
                                <input type=\"text\" name=\"title\" class=\"input_title KR_font\" maxlength=\"20\" placeholder=\"제목을 입력해주세요.(20자 이내)\">
                                <textarea name=\"content\" class=\"KR_font\" id=\"input_content\" maxlength=\"300\" placeholder=\"오늘 무슨일을 겪었나요?\"></textarea>
                                <p class=\"KR_font\" id=\"textCount\">0/300</p>
                            </div>
                            <script>
                                var contentsBox = document.getElementById(\"input_content\");
                                var wordCounter = document.getElementById(\"textCount\");
                                contentsBox.addEventListener(\"keyup\", KeyPress);
                                function KeyPress() {
                                    wordCounter.innerText = contentsBox.textLength + \"/300\";
                                }
                            </script>
                        </form>
                    </div>
                </div>
                ";
            }else{
                echo "<script>alert('로그인 후 이용해 주세요');</script>";
                echo "<script>location.href='./login.php';</script>";
            }
            ?>
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
</body>
<?php include "mysql_close.php"; ?>
</html>
