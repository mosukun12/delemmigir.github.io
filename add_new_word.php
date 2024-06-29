<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>Adding...</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/png" href="images/favicon.png">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <link rel="stylesheet" type='text/css' href="style1.css">
      <link rel="stylesheet" type='text/css' href="style2.css">
      <link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet' type='text/css'>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.default.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
  <body>
<?php
    include("include_header.html"); 
$con = mysqli_connect("localhost", "root", "");
if(!$con) {
    die("Could not connect: " . mysqli_error($con));
}
mysqli_set_charset($con,"utf8");
mysqli_select_db($con, "lexicon");

$w_name = mysqli_real_escape_string($con, $_POST['w_name']);
$w_lang = mysqli_real_escape_string($con, $_POST['lang']);
$w_type = mysqli_real_escape_string($con, $_POST['type']);
$type_desc = mysqli_real_escape_string($con, $_POST['type_desc']);
$w_letter = mysqli_real_escape_string($con, $_POST['w_letter']);
$phonetic = mysqli_real_escape_string($con, $_POST['phonetic']);
$ipa = mysqli_real_escape_string($con, $_POST['ipa']);
$origin = mysqli_real_escape_string($con, $_POST['origin']);
$mn1 = mysqli_real_escape_string($con, $_POST['mn1']);
$mn2 = mysqli_real_escape_string($con, $_POST['mn2']);
$mn3 = mysqli_real_escape_string($con, $_POST['mn3']);
$mn4 = mysqli_real_escape_string($con, $_POST['mn4']);
$mn5 = mysqli_real_escape_string($con, $_POST['mn5']);
$mn6 = mysqli_real_escape_string($con, $_POST['mn6']);
$ex1 = mysqli_real_escape_string($con, $_POST['ex1']);
$ex2 = mysqli_real_escape_string($con, $_POST['ex2']);
$ex3 = mysqli_real_escape_string($con, $_POST['ex3']);
$ex4 = mysqli_real_escape_string($con, $_POST['ex4']);
$ex5 = mysqli_real_escape_string($con, $_POST['ex5']);
$ex6 = mysqli_real_escape_string($con, $_POST['ex6']);
$audioFileName = mysqli_real_escape_string($con, $_FILES['audio']['name']);
$audioFilePath = 'audio/' . $audioFileName;

// Check if tag is an array
if(isset($_POST['tag']) && is_array($_POST['tag'])) {
    $tags = $_POST['tag'];
    $tag_string = implode(',', $tags);
    $tag = mysqli_real_escape_string($con, $tag_string);
} else {
    // If tag is not an array, set it to an empty string
    $tag = '';
}

if (!empty($audioFileName)) {
    if ($_FILES['audio']['error'] > 0)
        echo "Error:" . $_FILES['audio']['error'] . "<br/>";
}
if(isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
    // รหัส UPLOAD_ERR_OK หมายถึงไม่มีข้อผิดพลาดเกิดขึ้นในการอัปโหลดไฟล์
    $allowed_audio_extensions = array('mp3', 'wav', 'ogg');
    $audioFileName = mysqli_real_escape_string($con, $_FILES['audio']['name']);
    $audioFileExt = pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($audioFileExt), $allowed_audio_extensions)) {
        echo "Error: Invalid audio file format. Please upload a valid audio file.";
        exit;
    }
}

move_uploaded_file($_FILES['audio']['tmp_name'], $audioFilePath);

$table_name = "w_$w_lang";
$create_table_query = "CREATE TABLE IF NOT EXISTS $table_name (
    w_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    w_name VARCHAR(255) NOT NULL,
    w_redt INT(11) NOT NULL,
    w_lang VARCHAR(50) NOT NULL,
    w_type VARCHAR(50) NOT NULL,
    type_desc TEXT NOT NULL,
    w_letter VARCHAR(255) NOT NULL,
    phonetic VARCHAR(255) NOT NULL,
    ipa VARCHAR(255) NOT NULL,
    audio VARCHAR(255) NOT NULL,
    tag VARCHAR(255) NOT NULL,
    origin TEXT NOT NULL,
    mn1 TEXT NOT NULL,
    mn2 TEXT NOT NULL,
    mn3 TEXT NOT NULL,
    mn4 TEXT NOT NULL,
    mn5 TEXT NOT NULL,
    mn6 TEXT NOT NULL,
    ex1 TEXT NOT NULL,
    ex2 TEXT NOT NULL,
    ex3 TEXT NOT NULL,
    ex4 TEXT NOT NULL,
    ex5 TEXT NOT NULL,
    ex6 TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;";

if (!mysqli_query($con, $create_table_query)) {
    echo "Error creating table: " . mysqli_error($con);
}

// Check if the tag table exists, if not, create it
$tag_table_name = "$table_name" . "_tag";
$create_tag_table_query = "CREATE TABLE IF NOT EXISTS $tag_table_name (
    w_id INT(11) UNSIGNED NOT NULL,
    tag_id INT(11) UNSIGNED NOT NULL
)";
mysqli_query($con, $create_tag_table_query);

$create_tag_table = "CREATE TABLE IF NOT EXISTS w_tag (
    tag_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tag_desc TEXT NOT NULL
)";

mysqli_query($con, $create_tag_table);

// Split tag string into individual tags
$individual_tags = explode(',', $tag);
foreach($individual_tags as $individual_tag) {
    $individual_tag = trim($individual_tag); // Remove any leading or trailing whitespace

    // Check if the tag exists in w_tag table
    $check_tag_query = "SELECT * FROM w_tag WHERE tag_desc = '$individual_tag'";
    $tag_result = mysqli_query($con, $check_tag_query);

    if(mysqli_num_rows($tag_result) == 0) {
        // If tag does not exist, insert it into w_tag table
        $insert_tag_query = "INSERT INTO w_tag (tag_desc) VALUES ('$individual_tag')";
        mysqli_query($con, $insert_tag_query);
    }
}

if(isset($_POST['tag'])) {
$multi_tags = $_POST['tag'];
$multi_tag_string = implode(',', $tags);
$multi_tag = mysqli_real_escape_string($con, $tag_string);
}

// Check if the w_name already exists in the table
$check_existing_query = "SELECT w_redt FROM $table_name WHERE w_name = '$w_name' ORDER BY w_id DESC LIMIT 1";
$existing_result = mysqli_query($con, $check_existing_query);

if(mysqli_num_rows($existing_result) > 0) {
    // If w_name already exists, update the redt count
    $existing_row = mysqli_fetch_assoc($existing_result);
    $recent_redt_num = $existing_row['w_redt'];

    // Calculate the new redt count
    $new_redt_num = $recent_redt_num + 1;
} else {
    // If w_name doesn't exist, set the redt count to 1
    $new_redt_num = 1;
}

$sql = "INSERT INTO $table_name (w_name, w_lang, w_type, type_desc, w_letter, phonetic, ipa, audio, origin, mn1, mn2, mn3, mn4, mn5, mn6, ex1, ex2, ex3, ex4, ex5, ex6, w_redt) 
VALUES ('$w_name', '$w_lang', '$w_type', '$type_desc', '$w_letter', '$phonetic', '$ipa', '$audioFileName', '$origin', '$mn1', '$mn2', '$mn3', '$mn4', '$mn5', '$mn6', '$ex1', '$ex2', '$ex3', '$ex4', '$ex5', '$ex6', '$new_redt_num')";

if (!empty($multi_tag)) {
$sql = "INSERT INTO $table_name (tag) 
VALUES ('$multi_tag')";

$rs = mysqli_query($con, $sql);
} 
if($rs) {
    // Get the ID of the inserted row
    $last_id = mysqli_insert_id($con);

    // Insert into tag table
    foreach($individual_tags as $individual_tag) {
        $individual_tag = trim($individual_tag); // Remove any leading or trailing whitespace

        // Check if the tag exists in w_tag table
        $check_tag_query = "SELECT * FROM w_tag WHERE tag_desc = '$individual_tag'";
        $tag_result = mysqli_query($con, $check_tag_query);

        if(mysqli_num_rows($tag_result) == 0) {
            // If tag does not exist, insert it into w_tag table
            $insert_tag_query = "INSERT INTO w_tag (tag_desc) VALUES ('$individual_tag')";
            mysqli_query($con, $insert_tag_query);
        }

        // Retrieve tag_id for the current tag
        $get_tag_id_query = "SELECT tag_id FROM w_tag WHERE tag_desc = '$individual_tag'";
        $tag_id_result = mysqli_query($con, $get_tag_id_query);
        $tag_id_row = mysqli_fetch_assoc($tag_id_result);
        $tag_id = $tag_id_row['tag_id'];

        // Insert into tag table
        $insert_tag_table_query = "INSERT INTO $tag_table_name (w_id, tag_id) VALUES ('$last_id', '$tag_id')";
        mysqli_query($con, $insert_tag_table_query);    
    }

    echo "<script>window.location='explore.php?search=". $w_name ."&language=". $w_lang ."';</script>";
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>
  </body>
    </html>
