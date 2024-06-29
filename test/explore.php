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
  <?php 
    include("include_header.html"); 
    // include("back-btn.php");
    ?>
    <div class="container">
    <section class="sec-top-root">
      <div class="sec-top-container">
        <form name="search" method="get" action="explore.php" onsubmit="return validateForm()">
          <div class="searchbar-container">
            <div class="site-search-container2">
            <input type="search" class="site-searchbar2" id="search" name="search" placeholder="Search" 
              <?php 
              if(isset($_GET['search'])) {
                echo "value=\"".$_GET["search"]."\"";
              }
              ?>
              />
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
              echo "<p class='wordname' id='wordName" . $row['w_id'] . "'>" . $row['w_name'] . "</p>";
              if (!empty($row['phonetic'])) {
                if (!empty($row['phonetic']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                  echo "<p class='wordphonetic' id='wordphonetic". $row['w_redt'] ."'>[" . $row['phonetic'] . "]</p>";
                } else {
                    echo "<p class='wordphonetic' id='wordphonetic". $row['w_redt'] ."'>" . $row['phonetic'] . "</p>";
                  }
                } elseif (!empty($row['ipa'])) {
                  if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                  echo "<p class='wordipa' id='wordipa". $row['w_redt'] ."'>[" . $row['ipa']. "]</p>";
                  } else { 
                    echo "<p class='wordipa' id='wordipa". $row['w_redt'] ."'>" . $row['ipa']. "</p>";
                    }
                }
                if (!empty($row['ipa'])) {
                  if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                  echo "<p class='wordipa hide' id='wordipa". $row['w_redt'] ."'>[" . $row['ipa']. "]</p>";
                  } else {
                    echo "<p class='wordipa hide' id='wordipa". $row['w_redt'] ."'>" . $row['ipa']. "</p>";
                  }
                }
              if (!(empty($row['ipa'])) && !(empty($row['phonetic']))) {
                echo "<button class='changeWordIPA' onclick='changeWordIPA" . $row['w_redt'] ."()'>";
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
              echo "<p class='wordLangLetter' id='wordLanguage'>(" . $row['w_letter'] . ")</p>";
              }
              echo "<div class='buttonsetting'>";
              echo "<button id='editbtn' class='editbtn'><i class='fa fa-pencil'></i></button>";
              echo "     <form name='delWord' method='post' action='delWord.php'>";
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
              $first_w_type = "abbreviation";
              $origin = $row['origin'];
              $tags = $row['tag'];
              $previous_w_type = "";
              if ($row['w_redt'] > 0) {
                // ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
                if (isset($_GET['search'])) {

                    $searchWord = mysqli_real_escape_string($con, $_GET['search']);
                    $sql = "SELECT * FROM $table WHERE w_name LIKE '%$searchWord%' ORDER BY w_type ASC";
                    $result = mysqli_query($con, $sql);
            
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['w_type'] == $first_w_type) {
                                  echo "</ol>";
                                  echo "<hr>";
                                  echo "<div class='word-type'>";
                                  if (isset($row['type_desc'])) {
                                  echo "<b><i>" . $row['w_type'] . "(" . $row['type_desc'] .")</i><br/></b>";
                                  } 
                                  // else {
                                  //   echo "<b><i>" . $row['w_type'] . "</i><br/></b>";
                                  // }
                                  echo "</div>";
                                  echo "<ol class='meaning-list'>";

                                  $previous_w_type = $row['w_type'];

                                  // echo "<div style='color:Blue'>";
                                  // echo "TEST First_w_type<br />";
                                  // echo    "</div>";

                                  if ($row['mn1'] != null) {
                                    echo    "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
                                    if ($row['ex1'] != null) {
                                      echo    "<div class='example-sentence'>";
                                      echo      "<p>". $row['ex1'] . "<br>";
                                      echo    "</div>";
                                    }
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
                                  if ($row['mn4'] != null) {
                                    echo    "<li class='meaning-list-content'>" . $row['mn4'] . "</li>";
                                    if ($row['ex4'] != null) {
                                      echo    "<div class='example-sentence'>";
                                      echo      "<p>". $row['ex4'] . "<br>";
                                      echo    "</div>";
                                    }
                                  }
                                  if ($row['mn5'] != null) {
                                    echo    "<li class='meaning-list-content'>" . $row['mn5'] . "</li>";
                                    if ($row['ex5'] != null) {
                                      echo    "<div class='example-sentence'>";
                                      echo      "<p>". $row['ex5'] . "<br>";
                                      echo    "</div>";
                                    }
                                  }
                                  if ($row['mn6'] != null) {
                                    echo    "<li class='meaning-list-content'>" . $row['mn6'] . "</li>";
                                    if ($row['ex6'] != null) {
                                      echo    "<div class='example-sentence'>";
                                      echo      "<p>". $row['ex6'] . "<br>";
                                      echo    "</div>";
                                    }
                                  }
                                } else if($row['w_type'] == $previous_w_type) {
                                    if ($code_existed < 0) {
                                    echo "</ol>";
                                    echo "<hr>";
                                    echo "<div class='word-type'>";
                                    if (isset($row['type_desc'])) {
                                      echo "<b><i>" . $row['w_type'] . "(" . $row['type_desc'] .")</i><br/></b>";
                                      } 
                                      // else {
                                      //   echo "<b><i>" . $row['w_type'] . "</i><br/></b>";
                                      // }
                                    echo "</div>";
                                    echo "<ol class='meaning-list'>";
                                  }
                                    // echo "<div style='color:yellow'>";
                                    // echo "TEST multi_w_type<br />";
                                    // echo $previous_w_type;
                                    // echo "</div>";

                                    if ($row['mn1'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
                                      if ($row['ex1'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex1'] . "<br>";
                                        echo    "</div>";
                                      }
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
                                    if ($row['mn4'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn4'] . "</li>";
                                      if ($row['ex4'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex4'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                    if ($row['mn5'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn5'] . "</li>";
                                      if ($row['ex5'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex5'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                    if ($row['mn6'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn6'] . "</li>";
                                      if ($row['ex6'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex6'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                } else {
                                  echo "</ol>";
                                    echo "<hr>";
                                    echo "<div class='word-type'>";
                                    if (isset($row['type_desc'])) {
                                      echo "<b><i>" . $row['w_type'] . "</b> " . $row['type_desc'] ."</i><br/>";
                                      } 
                                      else {
                                        echo "<b><i>" . $row['w_type'] . "</i><br/></b>";
                                      }
                                    echo "</div>";
                                    echo "<ol class='meaning-list'>";

                                    $previous_w_type = $row['w_type'];
                                    $code_existed = 1;
                                    // echo "<div style='color:red'>";
                                    // echo "TEST previous_w_type<br />";
                                    // echo $previous_w_type;
                                    // echo "</div>";

                                    if ($row['mn1'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
                                      if ($row['ex1'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex1'] . "<br>";
                                        echo    "</div>";
                                      }
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
                                    if ($row['mn4'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn4'] . "</li>";
                                      if ($row['ex4'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex4'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                    if ($row['mn5'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn5'] . "</li>";
                                      if ($row['ex5'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex5'] . "<br>";
                                        echo    "</div>";
                                      }
                                    }
                                    if ($row['mn6'] != null) {
                                      echo    "<li class='meaning-list-content'>" . $row['mn6'] . "</li>";
                                      if ($row['ex6'] != null) {
                                        echo    "<div class='example-sentence'>";
                                        echo      "<p>". $row['ex6'] . "<br>";
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
              if (!empty($tags)) {
                $sql = "SELECT * FROM $table WHERE w_name = '$searchWord'";
                $result = mysqli_query($con, $sql);
              // echo   "<div class='recentAndCreated'>";
              // echo     "<p>Last edited: " . $row['latest_edited'] . "</p>";
              // echo     "<p>Create date: " . $row['date'] . "</p>";
              // echo   "</div>";
              echo   "<hr>";
              echo   "<div class='category-list'>";
              echo     "<div class='cat-title'>CATEGORY:</div>";
              echo     "<ul class='category-list-content'>";
              if ($tags != null) {
                $tag = $tags;
                $individual_tags = explode(',', $tag);
        
                foreach ($individual_tags as $tag_item) {
                    echo "<a href='browse.php?search=$tag_item'>";
                    echo "<li class='cate-btn'><div class='tag_item'>$tag_item</div></li>";
                    echo "</a>";
                }

              //   foreach ($individual_tags as $tag_item) {
              //     echo     "<ul class='category-list-content'>";
              //     echo "<button class='cate-btn'><a class='browselink' href='browse.php?search=" . $searchWord ."><div class='tag_item'>$tag_item</div></a></button>";
              // }
        
                // If there are fewer than 2 tags, fill the remaining <li> with empty content
                $remaining_li = max(0, 1 - count($individual_tags));
                for ($i = 0; $i < $remaining_li; $i++) {
                    echo "<li class='cate-box'></li>";
                }
              } else {
                echo "<li class='cate-box-none'>NONE</li>";
              }
            }

              echo "</div>";
              echo "</div>";
              echo "</div>";

              //ส่วนแสดง ORIGIN ของคำศัพท์
              if(!empty($origin)) {
              $sql = "SELECT * FROM $table WHERE w_name = '$searchWord' LIMIT 1";
              $result = mysqli_query($con, $sql);
      
              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                  
                    echo "<div class='content-list-word-root'>";
                    // echo "<div class='lang-top'>" . ucfirst($row['w_lang']) . "</div>";
                    echo "<div class='content-list-word-container'>";
                    echo "<section class='content-list-word content-top' id='mywords'>";
                    echo "<div class='content-word-item' id='word" . $row['w_id'] . "'>";
                    echo "<div class='Origin-text'>";
                    echo "    <h3>ORIGIN OF ". strtoupper($row['w_name']) ."</h3>";
                    echo "</div>";

                    echo "<div class='buttonsetting'>";
                    echo "<button id='editbtn' class='editbtn'><i class='fa fa-pencil'></i></button>";
                    echo "     <form name='delWord' method='post' action='delWord.php'>";
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

                    if ($row['w_redt'] > 0) {
                      // ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
                      if (isset($_GET['search'])) {
      
                          $searchWord = mysqli_real_escape_string($con, $_GET['search']);
                          $sql = "SELECT * FROM $table WHERE w_name LIKE '%$searchWord%' ORDER BY w_type ASC";
                          $result = mysqli_query($con, $sql);
                  
                          if (isset($_GET['search']) && !empty($_GET['search'])) {
                              if (mysqli_num_rows($result) > 0) {
                                  while ($row = mysqli_fetch_assoc($result)) {
                                        echo "</ol>";
                                        echo "<div class='word-type'>";
                                        echo "</div>";
                                        echo "<ol class='meaning-list'>";

                                        // echo "<div style='color:Blue'>";
                                        // echo "TEST First_w_type<br />";
                                        // echo    "</div>";
      
                                        if ($row['origin'] != null) {
                                          echo    "<li class='meaning-list-content'>" . $row['origin'] . "</li>";
                                        }
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
                
              
              $tables = array(
                "w_mellas",
                "w_dellin",
                "w_koshehmesh",
                "w_osmeneshien",
                "w_penaluir"
            );
          
            foreach ($tables as $table1) {
              $sql1 = "SELECT * FROM $table1 WHERE w_name LIKE '%$searchWord%'";
              $result1 = mysqli_query($con, $sql1);
            
              if (mysqli_num_rows($result1) > 0) {
                  while ($row1 = mysqli_fetch_assoc($result1)) {
                      $row1['table_name'] = ucfirst(str_replace('w_', '', $table1));
                      $data1[] = $row1;
                  }
              }
            }

          
            if (!empty($data1)) {
              $unique_w_names1 = array();
              $unique_w_names2 = array();
              $relative_existed = 0;
              $WHAT = "";
              $WORDC = "";

              foreach ($data1 as $row2) {
                $key2 = $row2['w_name'] . '-' . $row2['table_name'];
                if (!in_array($key2, $unique_w_names2)) {
                  $unique_w_names2[] = $key2;
                  if($WHAT > 0) {
                    $relative_existed++;
                    $WORDC++;
                  } 
                  $WHAT++;
                }
              }

              if ($relative_existed > 0) {
              echo "<div class='RelatedVocab'>";
              echo "<div class='RelatedVocab-text'>";
              echo "    <h3>".strtoupper("Related Vocab")."</h3>";
              echo "    <div class='color-white'>";
              // echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";
              }

              foreach ($data1 as $row1) {
                  $key1 = $row1['w_name'] . '-' . $row1['table_name'];
                  if ($_GET['language'] == lcfirst($row1['table_name'])) {
                      continue;
                  }
                  
                  if (!in_array($key1, $unique_w_names1)) {
                      $unique_w_names1[] = $key1;
                      // echo "<span style='float:right'>" . $row1['table_name'] . "</span>";
                      echo "・" . "<a class='explorelink' href='explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']) . "'>" . $row1['w_name'] . "</a>" . " (".$row1['table_name'].")<br />";
                      $relative_existed = 1;
                    }
              }
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
          

              $data = array();
              foreach ($tables as $table) {
                $sql = "SELECT * FROM $table ORDER BY date DESC LIMIT 25";
                $result = mysqli_query($con, $sql);
              
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $row['table_name'] = ucfirst(str_replace('w_', '', $table));
                        $data[] = $row;
                    }
                }
              }
              function compare($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
              }
              $data = array_slice($data, 0, 25);
              
              mysqli_close($con);
              
              if ($WORDC < 0) {
              echo "<div class='LatestAdd'>";
              echo "<div class='LatestAdd-text'>";
              echo "    <h3>".strtoupper("Latest Added Vocab")."</h3>";
              echo "    <div class='color-white'>";
              echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";

              if (!empty($data)) {
                $unique_w_names = array();
                foreach ($data as $row) {
                    $key = $row['w_name'] . '-' . $row['table_name'];
                    if (!in_array($key, $unique_w_names)) {
                        $unique_w_names[] = $key;
                        echo "<span style='float:right'>" . $row['table_name'] . "</span>";
                        echo "・" . "<a class='explorelink' href='explore.php?search=" . $row['w_name'] . "&language=".  lcfirst($row['table_name']) . "'>" . $row['w_name'] . "</a>" . "<br />";
                    }
                }
            }
          } else {
            echo "<div class='RightLatestAdd'>";
            echo "<div class='RightLatestAdd-text'>";
            echo "    <h3>".strtoupper("Latest Added Vocab")."</h3>";
            echo "    <div class='color-white'>";
            echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";

            if (!empty($data)) {
              $unique_w_names = array(); // เก็บ $row['w_name'] ที่เป็น unique
              foreach ($data as $row) {
                  // ตรวจสอบว่า $row['w_name'] และ $row['table_name'] ซ้ำกันหรือไม่
                  $key = $row['w_name'] . '-' . $row['table_name'];
                  if (!in_array($key, $unique_w_names)) {
                      // ถ้าไม่ซ้ำกัน ให้แสดงผล
                      $unique_w_names[] = $key;
                      echo "<span style='float:right'>" . $row['table_name'] . "</span>";
                      echo "・" . "<a class='explorelink' href='explore.php?search=" . $row['w_name'] . "&language=".  lcfirst($row['table_name']) . "'>" . $row['w_name'] . "</a>" . "<br />";
                  }
              }
          }
          echo "<a href='dictionary.php'><div style='font-size: 15px; margin-top: 10px; margin-bottom: 0px; color:#FFC300; opacity:100%;'>SEE MORE</div></a>";

          }
    }
  } else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    echo "<p style='font-family: Palanquin Dark, Kanit; font-size: 26px; margin-top: 15px; margin-bottom: 20px;   text-align: center !important;'>Your word not found.</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='LatestAdd' style='float: left !important;'>";
    echo "<div class='LatestAdd-text'>";
    echo "    <h3>".strtoupper("Latest Added Vocab")."</h3>";
    echo "    <div class='color-white'>";
    echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";

    $tables = array(
      "w_mellas",
      "w_dellin",
      "w_koshehmesh",
      "w_osmeneshien",
      "w_penaluir"
  );

    $data = array();
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
    function compare($a, $b) {
      return strtotime($b['date']) - strtotime($a['date']);
    }
    
    // Limit the data array to 25 elements
    $data = array_slice($data, 0, 25);
    
    mysqli_close($con);

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
    echo "<a href='dictionary.php'><div style='font-size: 15px; margin-top: 10px; margin-bottom: 10px; color:#FFC300; opacity:100%;'>SEE MORE</div></a>";
    echo "</section>";
    echo "</div>";
    echo "</div>";
  } } else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    echo "<span>What is the word you want to find?</span>";
    echo "</div>";
    echo "</section>";
    echo "</div>";
    echo "</div>";
    echo "<div class='LatestAdd' style='float: left !important;'>";
    echo "<div class='LatestAdd-text'>";
    echo "    <h3>".strtoupper("Latest Added Vocab")."</h3>";
    echo "    <div class='color-white'>";
    echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";

    $tables = array(
      "w_mellas",
      "w_dellin",
      "w_koshehmesh",
      "w_osmeneshien",
      "w_penaluir"
  );

    $data = array();
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
    function compare($a, $b) {
      return strtotime($b['date']) - strtotime($a['date']);
    }
    
    // Limit the data array to 25 elements
    $data = array_slice($data, 0, 25);
    
    mysqli_close($con);

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
    echo "<a href='dictionary.php'><div style='font-size: 15px; margin-top: 10px; margin-bottom: 10px; color:#FFC300; opacity:100%;'>SEE MORE</div></a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
    ?>
    </section>
    <script>


  document.getElementById('deletebtn" . $row['w_lang'] . $row['w_id'] . "').addEventListener('click', function() {
document.getElementById('deleteModal" . $row['w_lang'] . $row['w_id'] . "').style.display = 'block';
});

document.getElementsByClassName('close')[0].addEventListener('click', function() {
document.getElementById('deleteModal" . $row['w_lang'] . $row['w_id'] . "').style.display = 'none';
});
document.getElementById('no').addEventListener('click', function() {
document.getElementById('deleteModal" . $row['w_lang'] . $row['w_id'] . "').style.display = 'none';
});
window.addEventListener('click', function(event) {
if (event.target == document.getElementById('deleteModal" . $row['w_lang'] . $row['w_id'] . "')) {
  document.getElementById('deleteModal" . $row['w_lang'] . $row['w_id'] . "').style.display = 'none';
}
});
</script>
  <script src="dictionary.js"></script>
</body>
</html>

