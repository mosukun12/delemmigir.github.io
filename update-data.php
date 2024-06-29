<?php
$con = mysqli_connect("localhost", "root", "", "lexicon");
if (!$con) {
    die("Could not connect: " . mysqli_error($con));
}
mysqli_set_charset($con, "utf8");

if (isset($_POST['identity_data'])) {
    $identity_data = mysqli_real_escape_string($con, $_POST['identity_data']);
}

if (isset($_POST['w_name'])) {
    $w_name = mysqli_real_escape_string($con, $_POST['w_name']);
}
if (isset($_POST['w_lang'])) {
    $w_lang = mysqli_real_escape_string($con, $_POST['w_lang']);
}
if (isset($_POST['w_type'])) {
    $w_type = mysqli_real_escape_string($con, $_POST['w_type']);
}
if (isset($_POST['type_desc'])) {
    $type_desc = mysqli_real_escape_string($con, $_POST['type_desc']);
}
if (isset($_POST['w_letter'])) {
    $w_letter = mysqli_real_escape_string($con, $_POST['w_letter']);
}
if (isset($_POST['phonetic'])) {
    $phonetic = mysqli_real_escape_string($con, $_POST['phonetic']);
}
if (isset($_POST['ipa'])) {
    $ipa = mysqli_real_escape_string($con, $_POST['ipa']);
}

if (isset($_FILES['audioNew']['name'])) {
    $audioFileName = mysqli_real_escape_string($con, $_FILES['audioNew']['name']);
}

// Upload the file to the server
if (isset($_FILES['audioNew']['tmp_name'])) {
    $uploadDirectory = "audio/"; // Directory to upload files
    $uploadFilePath = $uploadDirectory . basename($_FILES['audioNew']['name']);
    move_uploaded_file($_FILES['audioNew']['tmp_name'], $uploadFilePath);
}

$table_name = "w_$w_lang";

if ($identity_data === "specific_data") {
    $sql = "UPDATE $table_name SET w_letter = '$w_letter', phonetic = '$phonetic', ipa = '$ipa', audio = '$audioFileName' WHERE w_name LIKE '$w_name'";
}

$rs = mysqli_query($con, $sql);

if (!$rs) {
    echo "Error: " . mysqli_error($con);
    exit;
} else {
    // echo "<script>alert('This is " . $audioFileName . "');</script>";
    echo "<script>window.location='explore.php?search=". $w_name ."&language=". $w_lang ."';</script>";
}

mysqli_close($con);
?>
