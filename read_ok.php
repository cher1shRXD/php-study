<?php 
include_once "./mysql_conn.php";
$check_read = $_POST['read'];
$recipter = $_POST['recipter'];

mysqli_query($conn, "UPDATE NOTICE SET `is_read` = '{$check_read}' WHERE `recipient` = '{$recipter}';");
include_once "./mysql_close.php";
?>