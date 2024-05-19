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
            error_reporting(E_ALL);
            ini_set("display_errors",1);
            if(isset($_SESSION['userid'])) {
                include_once "./mysql_conn.php";
                $current_id = $_POST['take_info'];
                if($current_id == "") {
                    $current_id = $_SESSION['userid'];
                }
                $sql = "SELECT * FROM USER WHERE id='$current_id';";
                $result = mysqli_query($conn,$sql);
                $get_myPosts = "SELECT * FROM BOARD WHERE `writer`='$current_id' AND `available` = 1 order by write_date desc;";
                $post_res = mysqli_query($conn,$get_myPosts);
                while ($row=mysqli_fetch_array($result)) {
                    $follower_num = $row['follower_num'];
                    $following_num = $row['following_num'];
                    if($following_num >= 10000) {
                        $following_num = round($following_num / 10000 , 2);
                        $following_num = "{$following_num}만";
                    }
                    if($follower_num >= 10000) {
                        $follower_num = round($follower_num / 10000 , 2);
                        $follower_num = "{$follower_num}만";
                    }
                    if(isset($_SESSION['userid'])) {
                        $follow_mode = './follow_no.svg';
                        $amI_follow = "SELECT * FROM `FOLLOW` WHERE `followed` = '$current_id' AND `following` = '{$_SESSION['userid']}';";
                        $check_fl = mysqli_query($conn, $amI_follow);
                        while(mysqli_fetch_array($check_fl)) {
                            if(mysqli_num_rows($check_fl) > 0) {
                                $follow_mode = './follow_yes.svg';
                            }
                        }
                    }
                    echo 
                    "
                    <div id=\"profile\">
                        <div id=\"info_area\">
                            <p class=\"KR_font\" id=\"profile_id\">$current_id</p>
                            <div id=\"empty\"></div>";
                            if($_SESSION['userid'] == $current_id) {
                                echo
                                "
                                <div id=\"btn-grp\">
                                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"info_refreshing();\">새로고침</button>
                                    <button type=\"button\" class=\"btn btn-dark\" onclick=\"info_editing();\">정보수정</button>
                                </div>
                                ";
                            }else{
                                echo "<img src=\"{$follow_mode}\" alt=\"\" class=\"followBtn\">";
                            }
                            echo "
                            <div id=\"fl_nums\">
                                <p class=\"KR_font\" id=\"follower_num\">팔로워: {$follower_num}명</p>
                                <p class=\"KR_font\" id=\"following_num\">팔로잉: {$following_num}명</p>
                            </div>
                        </div>
                    ";
                    echo 
                    "
                        <div id=\"my_post\">
                    ";
                    $cnt_row = mysqli_num_rows($post_res);
                    if($cnt_row > 0) {
                        while($post_row=mysqli_fetch_array($post_res)) {
                            $title = $post_row['post_title'];
                            $post_id = $post_row['post_id'];
                            $picture = $post_row['post_picture'];
                            $main_content = $post_row['post_content'];
                            $datetime = $post_row['write_date'];
                            $likes_num = $post_row['likes_num'];
                            $comments_num = $post_row['comments_num'];
                            if($comments_num > 99) {
                                $comments_num = '99+';
                            }
                            if($likes_num > 99) {
                                $likes_num = '99+';
                            }
                            echo
                            "
                            <div class=\"MyPost\">";
                                if($_SESSION['userid'] == $current_id) {
                                    echo
                                    "
                                    <form action=\"./delete_post.php\" method=\"POST\" onsubmit=\"return confirm('정말로 글을 삭제하시겠습니까?');\">
                                        <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                                        <button type=\"submit\" class=\"KR_font delete_btn\">글 삭제</button>
                                    </form>
                                    ";
                                }
                                if(!empty($picture)) {
                                    $tmp_checkExt = explode(".",$picture);
                                    $checkExt = end($tmp_checkExt);
                                    $ext_list = array('mp4','mpeg','avi');
                                    if(in_array($checkExt, $ext_list)) {
                                        echo
                                        "
                                        <div class=\"my-pic\">
                                            <video src=\"./uploads/$picture\" autoplay loop muted>
                                        </div>
                                        ";
                                    }else{
                                        echo
                                        "
                                        <div class=\"my-pic\">
                                            <img src=\"./uploads/$picture\">
                                        </div>
                                        ";      
                                    }
                                    
                                }else{
                                    echo
                                    "
                                    <div class=\"my-pic\">
                                        <img src=\"./no_pic.png\">
                                    </div>
                                    ";
                                }
                                echo
                                "
                                <div class=\"interaction\">
                                    <img src=\"./like_no.svg\" alt=\"\" class=\"likeBtn\"\">
                                    <p class=\"KR_font likes_num\">$likes_num</p>
                                    <img src=\"./comment.svg\" alt=\"\" class=\"commentBtn\">
                                    <p class=\"KR_font comments_num\">$comments_num</p>
                                </div>
                            </div>
                            
                            ";
                        }
                    }else{
                        echo "<p style=\"color: gray; font-size:7rem\" class=\"KR_font\">글이 없어요.. 어서 써주세용 !^_^!</p>";
                    }
                            
                    echo 
                    "
                        </div>
                    </div>
                    ";
                    
                }
            }else{
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
