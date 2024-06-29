<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Lexicon</title>
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
        <div class="site-root">
            <div class="site-home-logo">
                <img src="images/De lem migir lexion logo.png" width="400px" alt="Logo of Project Lexicon"/>
            </div>
            <div class="site-content">
                <div class="site-desc">
                    Choose one before you search anything.
                </div>
                <form name="language" method="get" action="checkingsearch.php">
                <div class="site-lang-select-list">
                    <input type="radio" name="language" value="dellin" id="dellinSelect">
                    <label for="dellinSelect"><span class="language-name">Dellin</span></label><br>
                    <input type="radio" name="language" value="mellas" id="mellasSelect">
                    <label for="mellasSelect"><span class="language-name">Mellas</span></label><br>
                    <input type="radio" name="language" value="koshehmesh" id="koshehmeshSelect">
                    <label for="koshehmeshSelect"><span class="language-name">Koshehmesh</span></label><br>
                    <input type="radio" name="language" value="penaluir" id="penaluirSelect">
                    <label for="penaluirSelect"><span class="language-name">Penaluir</span></label><br>
                    <input type="radio" name="language" value="osmeneshien" id="osmeneshienSelect">
                    <label for="osmeneshienSelect"><span class="language-name">Osmeneshien</span></label><br>
                </div>
                <div class="site-search-container">
                    <input type="search" class="site-searchbar" id="search" name="search" placeholder="Search" />
                </div>
                </form>
            </div>
            <?php
                include("connect.php");
                $tables = array(
                    "w_mellas",
                    "w_dellin",
                    "w_koshehmesh",
                    "w_osmeneshien",
                    "w_penaluir"
                  );
              
                echo "<div class='index-RandomWord'>";
                echo "<div class='index-RandomWord-text'>";
                echo "    <h3>".strtoupper("Random A Vocabulary")."</h3>";
                echo "<button type='button' class='index-RandomButton' id='RandomButton' onclick='location.reload(true)'>";
                echo "<img src='images/refresh.png' alt='Refresh Button' />";
                echo "</button>";
                echo "    <div class='color-white'>";
                $searchWord = "";
              
                function getRandomWord($lang) {
                  global $con;
                  $table = "w_" . $lang;
                  $sql = "SELECT w_name FROM $table ORDER BY RAND() LIMIT 1";
                  $result = mysqli_query($con, $sql);
                  if (mysqli_num_rows($result) > 0) {
                      $row = mysqli_fetch_assoc($result);
                      return $row['w_name'];
                  } else {
                      return "No word found";
                  }
                }
                $data3 = array(); // สร้าง array เพื่อเก็บข้อมูล
                
                foreach ($tables as $table3) {
                  $sql3 = "SELECT * FROM $table3 WHERE w_name LIKE '%$searchWord%'";
                  $result3 = mysqli_query($con, $sql3);
                
                  if (mysqli_num_rows($result3) > 0) {
                      while ($row3 = mysqli_fetch_assoc($result3)) {
                          $row3['table_name'] = ucfirst(str_replace('w_', '', $table3));
                          $data3[] = $row3;
                      }
                  }
                }
            
                if (!empty($data3)) {
                  $randomRow = $data3[array_rand($data3)]; // เลือกแถวสุ่มจาก $data3
                  $randomLang = $randomRow['w_lang'];
                  $randomWord = getRandomWord($randomLang);
                  $randomType = $randomRow['w_type'];
                  echo "<div class='index-word-detail'>";
                  echo "<div class='index-randomlang-box'>";
                  echo "<span style='font-size: 24px;'>$randomLang</span>";
                  echo "</div>";
                  echo "<div class='index-RandomWord-header'><a href='explore.php?search=". $randomWord . "&language=". $randomLang . "'>$randomWord</a></div>";
                
                  $table = "w_" . $randomLang;
                  $sql = "SELECT * FROM $table WHERE w_name = '$randomWord' LIMIT 1";
                  $result = mysqli_query($con, $sql);
                
                  // if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<div class='random-container'>";
                      if (!empty($row['phonetic'])) {
                        if (!empty($row['phonetic']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                          echo "<p class='random-wordphonetic' id='wordphonetic". $row['w_redt'] ."'>[ " . $row['phonetic'] . " ]</p>";
                        } else {
                            echo "<p class='random-wordphonetic' id='wordphonetic". $row['w_redt'] ."'>" . $row['phonetic'] . "</p>";
                          }
                        } elseif (!empty($row['ipa'])) {
                          if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                          echo "<p class='random-wordipa' id='wordipa". $row['w_redt'] ."'>/ " . $row['ipa']. " /</p>";
                          } else { 
                            echo "<p class='random-wordipa' id='wordipa". $row['w_redt'] ."'>" . $row['ipa']. "</p>";
                            }
                        }
                        if (!empty($row['ipa'])) {
                          if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                          echo "<p class='random-wordipa hide' id='wordipa". $row['w_redt'] ."'>/ " . $row['ipa']. " /</p>";
                          } else {
                            echo "<p class='random-wordipa hide' id='wordipa". $row['w_redt'] ."'>" . $row['ipa']. "</p>";
                          }
                        }
                      if (!(empty($row['ipa'])) && !(empty($row['phonetic']))) {
                        echo "<button class='random-changeWordIPA' onclick='changeWordIPA" . $row['w_redt'] ."()'>";
                        echo "<div class='showIPA' id='showIPA'>SHOW IPA</div>";
                        echo "</button>";
                        }
                      if (!(empty($row['audio']))) {
                      echo "<audio id='pronounce' class='display: none; visibility:hidden; hide'>";
                      echo "<source src='audio/". $row['audio'] . "' type='audio/mp3'>";
                      echo "Your browser does not support the audio element.";
                      echo "</audio>";
                      echo "<button class='audio-btn' onclick='playAudio()'><img src='images/Speaker_Icon.png'></button>";
                      }
                      if (!empty($row['w_letter'])) {
                      echo "<p class='random-wordLangLetter' id='wordLanguage'>(" . $row['w_letter'] . ")</p>";
                      }
                      echo "</div>";
                      echo "<div class='hr-word'></div>";
                  
                      echo "<span1><i>".$row['w_type']."</i></span1><br />";
                      echo "<div class='meaning-random'>";
                      echo "<div class='meaning-random-list-content'><span2>".$row['mn1']."</span2></div><br />";
                      echo "<div class='lookitup'><a href='explore.php?search=". $randomWord . "&language=". $randomLang . "'>LOOK IT UP</a></div>";
                      echo "</div>";
                    }
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            ?>
        </div>
    </div>
    <script src="dictionary.js"></script>
</body>
</html>