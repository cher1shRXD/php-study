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
            <img src="./bg.jpg" alt="" id="background">
            <?php include "../main/header.php"; ?>
            <div id="main">
                <div id="sen">
                    <?php 
                        error_reporting(E_ALL);
                        ini_set("display_errors",1);
                        include_once "./mysql_conn.php";
                        if(isset($_SESSION['userid'])) {
                            $my_name = $_SESSION['userid'];
                            $get_notice = mysqli_query($conn, "SELECT * FROM NOTICE WHERE `recipient` = '$my_name' AND `is_read` = 'no';");
                            $cnt_notices = mysqli_num_rows($get_notice);
                        }
                        
                        $ran_num = mt_rand(1,25);
                        $get_phrase = "SELECT * FROM PHRASE WHERE `phrase_id` = '$ran_num';";
                        $ph_query = mysqli_query($conn, $get_phrase);
                        while($ph_row=mysqli_fetch_array($ph_query)) {
                            $phrase = $ph_row['para'];
                        }
                        echo "<p>\"{$phrase}\"</p>";
                    ?>
                    
                </div>
                <?php 
                    error_reporting(E_ALL);
                    ini_set("display_errors",1);
                    $followBtn = "follow.svg";
                    $sql = "SELECT * FROM BOARD WHERE `available` = 1 order by post_id desc;";
                    $result = mysqli_query($conn,$sql);
                    $cnt_row = mysqli_num_rows($result);
                    if($cnt_row > 0) {
                        while ($row=mysqli_fetch_array($result)) {
                            $post_id = $row['post_id'];
                            $like_id = $post_id.'like';
                            $comment_id = $post_id.'comment_cnt';
                            $writer = $row['writer'];
                            $title = $row['post_title'];
                            $main_contents = $row['post_content'];
                            $picture = $row['post_picture'];
                            $writed_date = $row['write_date'];
                            if(isset($_SESSION['userid'])) {
                                $follow_mode = './follow_no.svg';
                                $amI_follow = "SELECT * FROM `FOLLOW` WHERE `followed` = '$writer' AND `following` = '{$_SESSION['userid']}';";
                                $check_fl = mysqli_query($conn, $amI_follow);
                                while(mysqli_fetch_array($check_fl)) {
                                    if(mysqli_num_rows($check_fl) > 0) {
                                        $follow_mode = './follow_yes.svg';
                                    }
                                }
                            }
                            echo 
                            "<div class=\"posts\">
                                <div class=\"user_id\">
                                    <p class=\"KR_font\" onclick=document.getElementsByClassName('$post_id')[0].click();>$writer</p>";
                                    if(isset($_SESSION['userid'])) {
                                        if($writer == $_SESSION['userid']) {
                                            echo "</div>";
                                        }else{
                                            echo "<img src=\"{$follow_mode}\" alt=\"\" class=\"followBtn {$_SESSION['userid']} {$writer}\" onclick=\"follow(this)\"> 
                                        </div>
                                        <form action=\"./profile_Page.php\" method=\"POST\" class=\"take_info\">
                                            <input type=\"hidden\" name=\"take_info\" value=\"{$writer}\" class=\"take_info\">
                                            <button type=\"submit\" class=\"take_info {$post_id}\"></button>
                                        </form>";
                                        }
                                    }else{
                                        echo 
                                        "
                                        </div>
                                        
                                        ";
                                    }
                                echo
                                "
                                <div class=\"main-box\">
                                    <div class=\"title-box\">
                                            <p class=\"KR_font title\">$title</p>
                                            <p class=\"KR_font datetime\">$writed_date</p>
                                        </div>";
                                    if(!empty($picture)) {
                                        $temp_checkExt = explode(".",$picture);
                                        $ext = end($temp_checkExt);
                                        $videoExt = array('mp4','mpeg','avi');
                                        if(in_array($ext, $videoExt)) {
                                            echo
                                            "
                                            <div class=\"picture_section\">
                                                <video src=\"./uploads/$picture\" alt=\"\" class=\"pictures\" controls>
                                            </div>
                                            "; 
                                        }else{
                                            echo
                                            "
                                            <div class=\"picture_section\">
                                                <img src=\"./uploads/$picture\" alt=\"\" class=\"pictures\">
                                            </div>
                                            "; 
                                        }
                                        
                                    }
                                    echo
                                    "
                                    <div class=\"word_section\">
                                        
                                        <div class=\"paragraph-box\">
                                            <p class=\"KR_font main_content\">$main_contents</p>
                                        </div>
                                    ";
                                    if(isset($_SESSION['userid'])) {
                                        $like_mode = './like_no.svg';
                                        $amI_like = "SELECT * FROM `LIKE` WHERE `post_id` = '{$post_id}' AND `liker` = '{$_SESSION['userid']}';";
                                        $Iam_like = mysqli_query($conn, $amI_like);
                                        $get_like_num = mysqli_query($conn, "SELECT * FROM `LIKE` WHERE `post_id` = '{$post_id}';");
                                        $get_comments_num = mysqli_query($conn, "SELECT * FROM `COMMENT` WHERE `post_id` = {$post_id};");
                                        $comments_num = mysqli_num_rows($get_comments_num);
                                        $likes_num = mysqli_num_rows($get_like_num);
                                        if($comments_num > 99) {
                                            $comments_num = '99+';
                                        }
                                        if($likes_num > 99) {
                                            $likes_num = '99+';
                                        }
                                        while(mysqli_fetch_array($Iam_like)) {
                                            if(mysqli_num_rows($Iam_like) > 0) {
                                                $like_mode = './like_yes.svg';  
                                            }
                                        }
                                        echo
                                        "
                                            <div class=\"interaction\">
                                                <img src=\"{$like_mode}\" alt=\"{$_SESSION['userid']}\" class=\"likeBtn {$writer}\" id=\"$post_id\" onclick=\"like(this)\">
                                                <p class=\"KR_font likes_num\" id=\"{$like_id}\">$likes_num</p>
                                                <img src=\"./comment.svg\" alt=\"{$post_id}comment\" class=\"commentBtn\" onclick=\"comment_window(this);\">
                                                <p class=\"KR_font comments_num\" id=\"{$comment_id}\">$comments_num</p>
                                            </div>
                                            <div class=\"comment_box\" id=\"{$post_id}comment\">
                                                <div class=\"comment_close\">
                                                    <img src=\"x-button.svg\" alt=\"{$post_id}comment\" onclick=\"comment_window(this);\">
                                                    <p>댓글</p>
                                                </div>
                                                <div class=\"comment_input\">
                                                    <input type=\"text\" id=\"{$post_id}_comm_cont\" class=\"input_comm_box\" placeholder=\"댓글을 입력해주세요.\" onKeyPress=\"if(event.keyCode==13){document.getElementById('{$post_id}_comm_btn').click();}\">
                                                    <button class=\"btn btn-dark {$_SESSION['userid']}\" id=\"{$post_id}_comm_btn\" alt=\"{$post_id}_comm_cont\" onclick=\"post_comment(this);\">게시</button>
                                                </div>
                                                <div class=\"comment_main\" id=\"{$_SESSION['userid']}{$post_id}\">
                                        ";
                                        $get_comments = mysqli_query($conn, "SELECT * FROM `COMMENT` WHERE `post_id` = '{$post_id}' ORDER BY comment_time DESC;");
                                        while($comm_row = mysqli_fetch_array($get_comments)) {
                                            $comm_writer = $comm_row['comment_writer'];
                                            $comm_main = $comm_row['comment_content'];
                                            $comm_time = $comm_row['comment_time'];
                                            $comment_id = $comm_row['comment_id'];
                                            $comm_like_mode = './like_no.svg';
                                            $comm_likes_num = $comm_row['comm_like_num'];
                                            $comm_like_id = $comment_id.'like';
                                            if($comm_likes_num > 99) {
                                                $comm_likes_num = '99+';
                                            }
                                            $amI_like = "SELECT * FROM `LIKE` WHERE `comment_id` = '{$comment_id}' AND `liker` = '{$_SESSION['userid']}';";
                                            $Iam_like = mysqli_query($conn, $amI_like);
                                            while(mysqli_fetch_array($Iam_like)) {
                                                if(mysqli_num_rows($Iam_like) > 0) {
                                                    $comm_like_mode = './like_yes.svg';  
                                                }
                                            }
                                            if(mysqli_num_rows($get_comments) > 0) {
                                                echo 
                                                "
                                                    <div class=\"comment\">
                                                        <p>{$comm_writer}</p>
                                                        <p>{$comm_main}</p>
                                                        <p>{$comm_time}</p>
                                                        <div class=\"comment_interaction\">
                                                            <img src=\"{$comm_like_mode}\" alt=\"{$_SESSION['userid']}\" class=\"{$comm_writer}\" id=\"{$comment_id}\" onclick=\"like_comm(this)\">
                                                            <p class=\"KR_font likes_num\" id=\"{$comm_like_id}\">$comm_likes_num</p>
                                                        </div>
                                                    </div>
                                                ";
                                            }else{
                                                echo
                                                "
                                                    <p>첫 댓글을 남겨보세요!</p>
                                                ";
                                            }
                                            
                                        }
                                        echo
                                        "
                                                </div>
                                            </div>
                                        ";
                                    }
                                echo 
                                "
                                    </div>
                                </div>  
                            </div>";
                        }
                    }else{
                        echo 
                        "
                        <div id=\"no\">
                            <img src=\"./nono.svg\" alt=\"\">
                            <p class=\"KR_font\"> 너무 썰렁하네용....</p>
                        </div>
                        ";
                    }
                    
                ?>
                
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
    <?php
        include_once "./mysql_close.php";
    ?>
</body>

</html>
