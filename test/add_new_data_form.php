<?php
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die("Could not connect: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
mysqli_select_db($con, "lexicon");

$tables = array(
    "w_mellas",
    "w_dellin",
    "w_koshehmesh",
    "w_osmeneshien",
    "w_penaluir"
);

$data = array();

// ตรวจสอบและสร้างตารางในกรณีที่ไม่มีตารางอยู่
if (empty($data)) {
    foreach ($tables as $table) {
        $create_table_query = "CREATE TABLE IF NOT EXISTS $table (
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
    }
}

function compare($a, $b) {
    return strtotime($a['date']) < strtotime($b['date']);
}

// Loop through each table
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table ORDER BY date DESC LIMIT 25";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Add table name to the row data
            $row['table_name'] = ucfirst(str_replace('w_', '', $table));
            // Push the row data into the data array
            $data[] = $row;
        }
    }
}

// Sort the data array by date in descending order
usort($data, 'compare');

// Limit the data array to 25 elements
$data = array_slice($data, 0, 25);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add new vocab</title>
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
</head>
<script>
function toggleClearButton(inputId) {
  var inputValue = document.getElementById(inputId).value;
  var clearButton = document.getElementById(inputId + "-clear");
  
  if (inputValue.trim() !== "") {
    clearButton.style.display = "inline-block";
  } else {
    clearButton.style.display = "none";
  }
}

// เรียกใช้งาน toggleClearButton เมื่อมีการเปลี่ยนแปลงใน input
document.addEventListener("DOMContentLoaded", function() {
  var inputs = document.querySelectorAll("input[type='text'], textarea");
  
  inputs.forEach(function(input) {
    input.addEventListener("input", function() {
      toggleClearButton(this.id);
    });
  });
});

// รีเซ็ตค่าของ input และปุ่มภาพเมื่อคลิกปุ่มลบไฟล์
function resetInput(inputId) {
  document.getElementById(inputId).value = ""; 
  toggleClearButton(inputId);
  toggleDeleteButton(inputId);
}

// แสดงหรือซ่อนปุ่มลบไฟล์เมื่อมีการเลือกไฟล์
function toggleDeleteButton(inputId) {
  var deleteButton = document.getElementById("delete-" + inputId + "-button");
  deleteButton.style.display = document.getElementById(inputId).value.trim() !== "" ? "inline-block" : "none";
}

// ลบไฟล์ที่เลือก
function deleteFile(inputId) {
  document.getElementById(inputId).value = "";
  toggleDeleteButton(inputId);
}
</script>

<body>
    <?php 
    include("include_header.html"); 
    // include("back-btn.php");
    ?>
        <div class="main-h-p">
          <div class="vacab-form-container" name="list">
              <div class="vacab-form-left" name="list">
                <h1>Add New Vocabulary</h1>
                <form name="add_word1" method="post" action="add_new_word.php" enctype="multipart/form-data">
                <input type="submit" value="Submit" name="submit-top" class="submit-box">
                <button type="reset" name="btn-reset" onclick="location.reload(true)">Reset all</button>&nbsp;
                <select name="lang" id="lang" required>
                        <option selected disabled hidden value="">Language</option>
                        <option value="dellin" name="dellin">Dellin</option>
                        <option value="mellas" name="mellas">Mellas</option>
                        <option value="koshehmesh" name="koshehmesh">Koshehmesh</option>
                        <option value="osmeneshien" name="osmeneshien">Osmeneshien</option>
                        <option value="penaluir" name="penaluir">Penaluir</option>
                </select>
                <select name="type" id="type" required>
                    <option selected disabled hidden value="">Part of speech</option>
                    <option value="abbreviation" name="abbreviation">Abbreviation</option>
                    <option value="adjective" name="adjective">Adjective</option>
                    <option value="adverb" name="adverb">Adverb</option>
                    <option value="conjunction" name="conjunction">Conjunction</option>
                    <option value="feminine" name="feminine">Feminine</option>
                    <option value="interjection" name="interjection">Interjection</option>
                    <option value="masculine" name="masculine">Masculine</option>
                    <option value="name" name="name">Name</option>
                    <option value="noun" name="noun">Noun</option>
                    <option value="past participle" name="past participle">Past participle</option>
                    <option value="plural" name="plural">Plural</option>
                    <option value="prefix" name="prefix">Prefix</option>
                    <option value="preposition" name="preposition">Preposition</option>
                    <option value="pronoun" name="pronoun">Pronoun</option>
                    <option value="pronominal" name="pronominal">Pronominal</option>
                    <option value="suffix" name="suffix">Suffix</option>
                    <option value="verb" name="verb">Verb</option>
                </select>
                <div class="vocab-form-input-container">
                <h5>Word</h5>
                    <input type="text" name="w_name" id="w_name" class="input-box" placeholder="mellanosius" autocomplete="off" required />
                    <button type="button" class="clear" id="w_name-clear" onclick="resetInput('w_name')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>Word Letters</h5>
                    <input type="text" name="w_letter" id="w_letter" class="input-box" placeholder="mellanOsius" autocomplete="off" />
                    <button type="button" class="clear" id="w_letter-clear" onclick="resetInput('w_letter')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>Phonetics</h5>
                    <input type="text" name="phonetic" id="phonetic" class="input-box" placeholder="[mel-la-noh-si-uhs]" autocomplete="off" />
                    <button type="button" class="clear" id="phonetic-clear" onclick="resetInput('phonetic')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>IPA</h5>
                    <input type="text" name="ipa" id="ipa" class="input-box" placeholder="['mella'nɔ.sius]" autocomplete="off" />
                    <button type="button" class="clear" id="ipa-clear" onclick="resetInput('ipa')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>Audio</h5>
                <div class="upload-file-box">
                    <input id="file-upload" name="audio" id="audio" type="file"/>
                </div>
                <h5>Type Description</h5>
                    <input type="text" name="type_desc" id="type_desc" class="input-box" autocomplete="off" >
                    <button type="button" class="clear" id="type_desc-clear" onclick="resetInput('type_desc')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>Origin</h5>
                    <input type="text" name="origin" id="origin" class="input-box" autocomplete="off" >
                    <button type="button" class="clear" id="origin-clear" onclick="resetInput('origin')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <h5>Categories</h5>
                    <select id="tag-input" class="input-box-tag" name="tag[]" multiple></select>
                    <button type="button" class="clear" id="tag-input-clear" onclick="resetInput('tag-input')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
                <script>
                $(document).ready(function() {
                  $('#tag-input').selectize({
                    plugins: ['remove_button'],
                    delimiter: ',',
                    persist: false,
                    create: function(input) {
                      return {
                        value: input,
                        text: input
                      }
                    }
                  });
                });
                </script>
                </div>
              </div>
              <div class="vacab-form-right" name="list">
                <div class="meaningAndExample" id="meaningAndExample1">
                  <div class="MnAndEx-form">
                      <h5>Meaning 1</h5>
                          <textarea name="mn1" id="mn1" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 1</h5>
                          <textarea name="ex1" id="ex1" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <div class="meaningAndExample hide" id="meaningAndExample2">
                  <div class="MnAndEx-form">
                      <h5>Meaning 2</h5>
                          <textarea name="mn2" id="mn2" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 2</h5>
                          <textarea name="ex2" id="ex2" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <div class="meaningAndExample hide" id="meaningAndExample3">
                  <div class="MnAndEx-form">
                      <h5>Meaning 3</h5>
                          <textarea name="mn3" id="mn3" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 3</h5>
                          <textarea name="ex3" id="ex3" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <div class="meaningAndExample hide" id="meaningAndExample4">
                  <div class="MnAndEx-form">
                      <h5>Meaning 4</h5>
                          <textarea name="mn4" id="mn4" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 4</h5>
                          <textarea name="ex4" id="ex4" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <div class="meaningAndExample hide" id="meaningAndExample5">
                  <div class="MnAndEx-form">
                      <h5>Meaning 5</h5>
                          <textarea name="mn5" id="mn5" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 5</h5>
                          <textarea name="ex5" id="ex5" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <div class="meaningAndExample hide" id="meaningAndExample6">
                  <div class="MnAndEx-form">
                      <h5>Meaning 6</h5>
                          <textarea name="mn6" id="mn6" class="input-comment-box"></textarea><br/>
                      <h5>Example sentence 6</h5>
                          <textarea name="ex6" id="ex6" class="input-comment-box"></textarea><br/>
                  </div>
                </div>
                <button type="button" class="addMeaning" onclick="addMeaning()">+</button>
                <button type="button" class="removeMeaning" onclick="removeMeaning()">-</button>
              </div>
            </form>
          </div>
        </div>
            <div class="form-box-root" name="list">
                <div class="form-box-text" name="list">
                    <h3>Latest Added Vocab</h3><a href="dictionary.php"><div style="font-size: 15px; margin-top: -10px; margin-bottom: 10px; color:#FFC300; opacity:100%;">see more</div></a>
                    <div class="color-white">
                    <span style="float:left; font-weight: 500; opacity: 70%;">Vocab</span><span style="float:right; font-weight: 500; opacity: 70%;">Language</span><br />
                    <?php
                        if (!empty($data)) {
                            $unique_w_names = array(); // เก็บ $row['w_name'] ที่เป็น unique
                            foreach ($data as $row) {
                                // ตรวจสอบว่า $row['w_name'] และ $row['table_name'] ซ้ำกันหรือไม่
                                $key = $row['w_name'] . '-' . $row['table_name'];
                                if (!in_array($key, $unique_w_names)) {
                                    // ถ้าไม่ซ้ำกัน ให้แสดงผล
                                    $unique_w_names[] = $key;
                                    echo "<span style='float:right'>" . $row['table_name'] . "</span>";
                                    echo "・" . "<a class='explorelink' href='explore.php?search=" . $row['w_name'] . "&language=". lcfirst($row['table_name']) . "'>" . $row['w_name'] . "</a>" . "<br />";
                                }
                            }
                        }
                         else { echo "There is no data."; }
                        ?>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <script>
let currentMeaning = 2; // Starting from the second meaningAndExample

if (currentMeaning === 2) {
      document.querySelector('.removeMeaning').style.display = 'none'; // Hide the - button when currentMeaning is 2
    }

function addMeaning() {
  if (currentMeaning <= 6) {
    document.getElementById(`meaningAndExample${currentMeaning}`).classList.remove('hide');
    currentMeaning++;
    if (currentMeaning > 6) {
      document.querySelector('button:first-of-type').style.display = 'none'; // Hide the + button
      document.querySelector('.addMeaning').style.display = 'none';
    }
    if (currentMeaning > 2) {
      document.querySelector('.removeMeaning').style.display = 'inline';
    }
  }
}


function removeMeaning() {
  if (currentMeaning > 2) {
    currentMeaning--;
    document.getElementById(`meaningAndExample${currentMeaning}`).classList.add('hide');
    if (currentMeaning < 6) {
      document.querySelector('button:first-of-type').style.display = 'inline'; // Show the + button
    }
    if (currentMeaning <= 2) {
      document.querySelector('button:last-of-type').style.marginTop = '0'; // Reset margin for - button
    }
    if (currentMeaning === 2) {
      document.querySelector('.removeMeaning').style.display = 'none'; // Hide the - button when currentMeaning is 2
    }
    if (document.querySelector('.addMeaning').style.display === 'none') {
      document.querySelector('.addMeaning').style.display = 'inline';
    }
  }
}

</script>
    <?php include("include_footer.html"); ?>
</body>
</html>
