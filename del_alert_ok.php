<?php 
include_once "./mysql_conn.php";
$recipter = $_POST['recipter'];
$noti_id = $_POST['notice'];
mysqli_query($conn, "DELETE FROM NOTICE WHERE `recipient` = '{$recipter}' AND `noti_id` = '$noti_id';");
include_once "./mysql_close.php";
?>