<?php
$con = mysqli_connect("localhost", "root", "", "timeblocks");
if(mysqli_connect_errno()) {
    echo mysqli_connect_error();
}

date_default_timezone_set('Asia/Jakarta');
ob_start();
?>