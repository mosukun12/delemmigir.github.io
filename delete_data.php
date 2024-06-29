<?php
// ตรวจสอบว่ามีค่า w_name ที่ถูกส่งมาหรือไม่
if(isset($_POST['w_name'])) {
    // เชื่อมต่อกับฐานข้อมูล MySQL
    $conn = new mysqli("localhost", "root", "", "lexicon");

    // เช็คการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $w_name = $_POST['w_name'];

    $sql = "DELETE FROM w_mellas WHERE w_name='$w_name'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
} else {
    echo "No w_name provided";
}
?>
