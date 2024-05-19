<?php
include_once "./mysql_conn.php";
error_reporting(E_ALL);
ini_set("display_errors",1);
@session_start();

$current_id = $_SESSION['userid'];


$sql = "SELECT * FROM USER WHERE id='$current_id'";
$result = mysqli_query($conn,$sql);
while ($row=mysqli_fetch_array($result)) {
    $_SESSION['follower_num'] = $row['follower_num'];
    $_SESSION['following_num'] = $row['following_num'];
}
echo "<script>history.back();</script>";

include_once "./mysql_close.php";
?>