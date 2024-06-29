<?php
    $con = mysqli_connect("localhost", "root", "");
    if(!$con) {
     die("Could not connect: " . mysqli_error($con)); // แก้ mysql_error() เป็น mysqli_error()
    }
    mysqli_set_charset($con,"utf8");
    mysqli_select_db($con, "lexicon");
?>