<?php
    @session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    if(isset($_SESSION['userid'])) {
        if($cnt_notices > 0) {
            $notice_icon = './notice_yes.svg';
        }else{
            $notice_icon = './notice_no.svg';
        }
        echo 
        "
        <div id=\"menubar\">
            <img src=\"./home.svg\" alt=\"\" onclick=\"GoHome();\">
            <img src=\"./AI.svg\" alt=\"\" onclick=\"GoSearch();\">
            <img src=\"./upload.svg\" alt=\"\" onclick=\"GoMake();\">
            <img src=\"{$notice_icon}\" alt=\"{$_SESSION['userid']}\" id=\"noti\" onclick=\"notice_window(this);\">
            <img src=\"./profile.svg\" alt=\"\" onclick=\"document.getElementsByClassName('myID')[0].click();\">
            <form action=\"./profile_Page.php\" method=\"POST\" class=\"take_info\">
                <input type=\"hidden\" name=\"take_info\" value=\"{$_SESSION['userid']}\" class=\"take_info\">
                <button type=\"submit\" class=\"take_info myID\"></button>
            </form>
        </div>
        ";
    }else{
        echo 
        "
        <div id=\"menubar\">
            <img src=\"./home.svg\" alt=\"\" onclick=\"GoHome();\">
            <img src=\"./AI.svg\" alt=\"\" onclick=\"GoSearch();\">
            <img src=\"./upload.svg\" alt=\"\" onclick=\"GoMake();\">
            <img src=\"./notice_no.svg\" alt=\"\" >
            <img src=\"./profile.svg\" alt=\"\" onclick=\"GoProfile();\">
        </div>
        ";
    }
?>
