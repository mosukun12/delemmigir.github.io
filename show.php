<?php session_start(); ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>Explore</title>
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
    <?php include("include_header.html"); ?>
    <div class="container">
    <section class="sec-top-root">
      <div class="sec-top-container">
        <form name="search" method="get" action="explore.php" onsubmit="return validateForm()">
          <div class="searchbar-container">
            <div class="site-search-container2">
              <input type="search" class="site-searchbar2" id="search" name="search" placeholder="Search" />
            </div>
            <div class="langSelection">
              <div class="langSelection-head">
                <span class="langSelection-head">Language :</span>
                <select name="language" id="language" onchange="sortFunction()">
                  <option <?php if(isset($_GET['language'])) {if(($_GET['language'] == "mellas")) { echo "selected"; }}?> value="mellas">Mellas</option> 
                  <option <?php if(isset($_GET['language'])) {if(($_GET['language'] == "dellin")) { echo "selected"; }}?> value="dellin">Dellin</option> 
                  <option <?php if(isset($_GET['language'])) {if(($_GET['language'] == "koshehmesh")) { echo "selected"; }}?> value="koshehmesh">Koshehmesh</option>
                  <option <?php if(isset($_GET['language'])) {if(($_GET['language'] == "omeneshien")) { echo "selected"; }}?> value="penaluir">Osmeneshien</option>
                  <option <?php if(isset($_GET['language'])) {if(($_GET['language'] == "penaluir")){ echo "selected"; }}?>  value="osmeneshien">Penaluir</option>
                </select>
              </div>
            </div>
            <div class="sortby-container">
            <div class="sortby-head">
              <i class="fa fa-sort"></i>
              <span class="sortby-text">Sort by</span>
              <select name="sortBy" id="sortBy" onchange="sortFunction()">
                <div class="select-dropdown">
                  <option selected disabled hidden>Sort By</option>
                  <option value="recent">Recent Updated</option> 
                  <option value="created">Created Date</option> 
                  <option value="AZ">A to Z</option>
                  <option value="ZA">Z to A</option>
                </div>
              </select>
            </div>
          </div>
        </form>                  
      </div>
    </section>
</div>
<section class="container">
      <?php 
      $con = mysqli_connect("localhost", "root", "", "lexicon");
      if (!$con) {
          die("Connection failed: " . mysqli_connect_error());
      }
      mysqli_set_charset($con, "utf8");

      if (isset($_GET['language']) && isset($_GET['search'])) {
        $table = "w_" . $_GET['language'];
        $searchWord = mysqli_real_escape_string($con, $_GET['search']);
    
        $sql = "SELECT * FROM $table WHERE w_name = '$searchWord'";
        $result = mysqli_query($con, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              
              echo "<div class='content-list-word-root'>";
              echo "<div class='lang-top'>" . ucfirst($row['w_lang']) . "</div>";
              echo "<div class='content-list-word-container'>";
              echo "<section class='content-list-word content-top' id='mywords'>";
              echo "<div class='content-word-item' id='word" . $row['w_id'] . "'>";
              echo "<p class='wordname' id='wordName" . $row['w_id'] . "'>" . $row['w_name'] . "</p><h2 class='wordredt'>(". $row['w_redt'] . ")</h2>";
              echo "<p class='wordphonetic' id='wordPhonetic'>" . $row['phonetic'] . "</p>";
              echo "<p class='wordipa hide' id='wordIPA'>" . $row['ipa']. "</p>";
              echo "<button class='changeWordIPA' onclick='changeWordIPA()'>";
              echo "<div class='showIPA'>SHOW IPA</div>";
              echo "</button>";
              echo "<audio id='pronounce" . $row['w_lang'] . $row['w_id'] . "' class='display: none; visibility:hidden; hide'>";
              echo "<source src='audio/". $row['audio'] . "' type='audio/mp3'>";
              echo "Your browser does not support the audio element.";
              echo "</audio>";
              echo "<button class='audio-btn' onclick='playAudio" . $row['w_lang'] . $row['w_id']."()'><img src='images/Speaker_Icon.png'></button>";
              if (!empty($row['w_letter'])) {
              echo "<p class='wordLangLetter' id='wordLanguage'>(" . $row['w_letter'] . ")</p>";
            }
              echo "<div class='buttonsetting'>";
              echo "<button id='editbtn' class='editbtn'><i class='fa fa-pencil'></i></button>";
              echo "     <form name='delWord' method='post' action='delWord.php'>";
              echo "        <input type='text' name='table' value='w_" . $row['w_lang'] . "' hidden/>";
              echo "        <input type='text' name='w_id' value='" . $row['w_id'] . "' hidden/>";
              echo "        <input type='text' name='w_name' value='" . $row['w_name'] . "' hidden/>";
              echo "        <input type='text' name='w_lang' value='" . $row['w_lang'] . "' hidden/>";
              echo "        <input type='text' name='w_type' value='" . $row['w_type'] . "' hidden/>";
              echo "        <input type='text' name='uniqueid' value='" . $row['w_lang'].$row['w_name'].$row['w_type'] . "' hidden/>";
              echo "<div id='deleteModal' class='modal'>";
              echo "  <!-- Modal content -->";
              echo "  <div class='modal-content'>";
              echo "    <span class='close'>&times;</span>";
              echo "      <span class='sureornot'>ARE YOU SURE TO DELETE THESE DATA?".$w_id."</span>";
              echo "    <div class='confirm-delete'>";
              echo "     <button type='submit' class='yes' value='YES, DELETE' onclick='delWord(". $row['w_id'] .")'><div class='delete-text'>YES, DELETE</div></button>";
              echo "     </form>";
              echo "     <button type='button' class='no' id='no' onclick='delWord(". $row['w_id'] .")'><div class='delete-text'>NO, MY MISTAKE</div></button>";
              echo "    </div>";
              echo "  </div>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo  "</section>";
              echo   "<hr>";
              echo   "<div class='word-type'>";
              echo     "<b><i>". $row['w_type'] ."</i><br/></b>";
              echo   "</div>";
              echo   "<ol class='meaning-list'>";
              echo    "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
              if ($row['ex1'] != null) {
                echo    "<div class='example-sentence'>";
                echo      "<p>". $row['ex1'] . "<br>";
                echo    "</div>";
              }
              if ($row['mn2'] != null) {
                echo    "<li class='meaning-list-content'>" . $row['mn2'] . "</li>";
                if ($row['ex2'] != null) {
                  echo    "<div class='example-sentence'>";
                  echo      "<p>". $row['ex2'] . "<br>";
                  echo    "</div>";
                }
              }
              if ($row['mn3'] != null) {
                echo    "<li class='meaning-list-content'>" . $row['mn3'] . "</li>";
                if ($row['ex3'] != null) {
                  echo    "<div class='example-sentence'>";
                  echo      "<p>". $row['ex3'] . "<br>";
                  echo    "</div>";
                }
              }
              if ($row['w_redt'] > 0) {
                // ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
                if (isset($_GET['search'])) {
                    $searchWord = mysqli_real_escape_string($con, $_GET['search']);
                    $sql = "SELECT * FROM $table WHERE w_name LIKE '%$searchWord%'";
            
                    // ดำเนินการค้นหาข้อมูล
                    $result = mysqli_query($con, $sql);
            
                    // ตรวจสอบเงื่อนไขเพื่อป้องกันการดำเนินการค้นหาเมื่อไม่มีการส่งคำค้นหามา
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        // ตรวจสอบว่ามีผลลัพธ์ที่พบหรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // วนลูปผลลัพธ์ที่พบ
                            while ($row = mysqli_fetch_assoc($result)) {
                                // ตรวจสอบเงื่อนไขว่า w_type เป็นค่าที่ต้องการหรือไม่
                                if ($row['w_type'] !== 'adverb') {
                                    // แสดงผลข้อมูลเพิ่มเติมที่ต้องการ
                                    echo "</ol>";
                                    echo "<hr>";
                                    echo "<div class='word-type'>";
                                    echo "<b><i>" . $row['w_type'] . "</i><br/></b>";
                                    echo "</div>";
                                    echo "<ol class='meaning-list'>";
                                    echo "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
                                    if ($row['ex1'] != null) {
                                        echo "<div class='example-sentence'>";
                                        echo "<p>" . $row['ex1'] . "<br>";
                                        echo "</div>";
                                    }
                                    if ($row['mn2'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn2'] . "</li>";
                                      if ($row['ex2'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex2'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                    if ($row['mn3'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn3'] . "</li>";
                                      if ($row['ex3'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex3'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                }
                            }
                        }
                    }
                }
            }
              echo   "</ol>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
    }
  } else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    echo "<p style='font-family: Palanquin Dark, Kanit; font-size: 26px; margin-top: 15px; margin-bottom: 20px;   text-align: center !important;'>Your word not found.</p>";
    echo "</div>";
    echo "</section>";
    echo "</div>";
    echo "</div>";
  }
  } else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    echo "<p style='font-family: Palanquin Dark, Kanit; font-size: 26px; margin-top: 15px; margin-bottom: 20px;   text-align: center !important;'>What is the word you want to find?</p>";
    echo "</div>";
    echo "</section>";
    echo "</div>";
    echo "</div>";
  }
    ?>
    </section>
    <script src="dictionary.js"></script>
  </body>
  </html>
