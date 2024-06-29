<?php 
session_start();

$con = mysqli_connect("localhost", "root", "", "lexicon");
if(!$con) {
    die("Could not connect: " . mysqli_error($con));
}
mysqli_set_charset($con,"utf8");

// Check if 'w_id', 'w_name', and 'w_lang' are set in $_POST

?>
