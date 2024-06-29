<?php 
session_start();

$con = mysqli_connect("localhost", "root", "", "lexicon");
if(!$con) {
    die("Could not connect: " . mysqli_error($con));
}
mysqli_set_charset($con,"utf8");
$w_lang = mysqli_real_escape_string($con, $_POST['w_lang']);
$table = "w_" . mysqli_real_escape_string($con, $_POST['w_lang']);

if(isset($_POST['w_name'])) {
    $w_name = mysqli_real_escape_string($con, $_POST['w_name']);
    
    // คำสั่ง SQL สำหรับลบข้อมูลตาม w_name
    $sql = "DELETE FROM $table WHERE w_name = '$w_name'";
    
    if(mysqli_query($con, $sql)) {
        echo "<script>alert('$w_name in " . ucfirst($w_lang) . " deleted successfully'); window.location='explore.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

?>
