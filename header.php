<?php
    if(isset($_SESSION['userid'])){
        @session_start();
    }
    $head_name = array('SSUL.IN','썰인');
    $print = $head_name[mt_rand(0,1)];
    echo
    "
    <div id=\"header\">
        <p onclick=\"GoHome();\">{$print}</p>
        <img src=\"./video.svg\" onclick=\"location.href='./video.html';\">
    </div>
    ";
?>
