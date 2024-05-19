<?php 
    $css_file = "style.css";
    $mAgent = array("iPad", "iPhone", "Android", "iPod", "Blackberry","Opera Mini", "Windows ce", "Nokia", "sony");
    $chkMobile = false;
    for($i=0; $i<sizeof($mAgent); $i++){
        if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
            $chkMobile = true;
            break;    
        }
    }
    if($chkMobile) {
        // $css_file = "style.css";
        $css_file = "PC_css.css";
    } 
    else {    
        $css_file = "PC_css.css";
    }
    

        
    
?>