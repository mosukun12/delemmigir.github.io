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
                  echo "<p class='wordphonetic' id='wordphonetic". $row['w_redt'] ."'>[ " . $row['phonetic'] . " ]</p>";
                } else {
                    echo "<p class='wordphonetic' id='wordphonetic". $row['w_redt'] ."'>" . $row['phonetic'] . "</p>";
                  }
                } elseif (!empty($row['ipa'])) {
                  if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                  echo "<p class='wordipa' id='wordipa". $row['w_redt'] ."'>/ " . $row['ipa']. " /</p>";
                  } else { 
                    echo "<p class='wordipa' id='wordipa". $row['w_redt'] ."'>" . $row['ipa']. "</p>";
                    }
                }
                if (!empty($row['ipa'])) {
                  if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
                  echo "<p class='wordipa hide' id='wordipa". $row['w_redt'] ."'>/ " . $row['ipa']. " /</p>";
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
              // echo "     <form name='delWord' method='post' action='delWord.php'>";
              echo "<div id='editModal' class='modal'>";
              echo "  <!-- Modal content -->";
              echo "  <div class='modal-content'>";
              echo "    <div class='close'>&times;</div>";
                          $w_name = $row['w_name'];
                          $w_lang = $row['w_lang'];
                          $rowphonetic = $row['phonetic'];

              echo "      <span class='modal-edit-text'>Specific Data of ".$row['w_name']."</span>";
              echo "    <div class='modal-edit-text-container'>";
              echo "    </div>";
              echo "    <div class='edit-data-container'>";
              echo "      <div class='edit-data-container-left'>";
              echo "      <form action='update-data.php' method='post' enctype='multipart/form-data'>";
              echo "        <div class='edit-data-section'>";
              echo "            <h3>Phonetic</h3>";
              echo "          <div class='edit-data-input'>";
              echo "            <input type='text' name='phonetic' id='phonetic' value='" . $row['phonetic'] . "' autocomplete='off'>";
              echo "          </div>";
              echo "        </div>";
              echo "        <div class='edit-data-section'>";
              echo "            <h3>IPA</h3>";
              echo "          <div class='edit-data-input'>";
              echo "            <input type='text' name='ipa' id='ipa' value='" . $row['ipa'] . "' autocomplete='off'>";
              echo "          </div>";
              echo "        </div>";
              echo "        <div class='edit-data-section'>";
              echo "            <h3>Audio";
              echo "            <audio id='pronounce' class='display: none; visibility:hidden; hide'>";
              echo "            <source src='audio/". $row['audio'] . "' type='audio/mp3'>";
              echo "            Your browser does not support the audio element.";
              echo "            </audio>";
              echo "            <button type='button' class='audio-btn' onclick='playAudio()'><img src='images/Speaker_Icon.png'></button>";
              echo "            (currently)</h3></div>";
              echo "          <div class='upload-file-box'>";
              echo "              <input id='file-upload' name='audioNew' id='audio' type='file'/>";
              echo "          </div>";
              echo "        <div class='edit-data-section'>";
              echo "            <h3>Letter</h3>";
              echo "          <div class='edit-data-input'>";
              echo "            <input type='text' name='w_letter' id='w_letter' value='" . $row['w_letter'] . "' autocomplete='off'>";
              echo "          </div>";
              echo "        </div>";
              echo "      </div>";
              echo "      <div class='edit-data-container-right'>";
              echo "        <div class='updatebtn-center'>";
              echo "          <button type='button' id='updateModal' class='updatebtn' onclick='previewEditInput()'>Update</button>";
              echo "        </div><br />";
              echo "        <div class='updatebtn-center'>";
              echo "          <button type='button' id='deleteModal' class='deletebtn1' onclick='confirmDelete()'>Delete</button>";
              echo "        </div>";
              echo "      </div>";
              echo "    </div>";
              echo "    <div class='modal2' id='modal2'>";
              echo "    <div class='close2'>&times;</div>";
              echo "      <div class='modal-update' id='modal-update'>";
              echo "        <div class='modal-update-confirm'>";
              echo "          <div class='modal-update-text'>";
              echo "            <h2>Confirm your edited data.</h2><br />";
              echo "            <span class='h3'>Word is ".$row['w_name']."</span><br />";
              echo "            <div class='whitespace1'>";
              echo "            <span class='p1'>Phonetic: <span class='editword-old2'>".$row['phonetic']."</span>";
              echo "              &gt; <span class='editword-new2' id='editword-new2-phonetic'></span><br />";
              echo "          <br />";
              echo "            <span class='p1'>IPA: <span class='editword-old2'>".$row['ipa']."</span>";
              echo "              &gt; <span class='editword-new2' id='editword-new2-ipa'></span><br />";

              echo "          <br />";
              echo "            <span class='p1'>Letter: <span class='editword-oldletterfont'>". $row['w_letter'] ."</span>";
              echo "              &gt; <span class='editword-newletterfont' id='editword-new-letter'></span><br />";

              echo "            <input type='text' name='identity_data' value='specific_data' hidden>";
              echo "            <input type='text' name='w_name' value='". $row['w_name'] ."' hidden>";
              echo "            <input type='text' name='w_lang' value='". $row['w_lang'] ."' hidden>";
              echo "            <input type='text' id='editphonetic' name='phonetic' hidden>";
              echo "            <input type='text' id='editipa' name='ipa' hidden>";
              echo "            <input type='text' id='editletter' name='w_letter' hidden>";
              // echo "<input type='text' name='audio' value='1' hidden>";

              echo "             <div id='confirmationUpdate' class='confirm-dialog'>";
              echo "              <br />";
              echo "              <button id='updateYes'>SAVE</button>";
              echo "              <button type='button' id='updateNo'>CANCEL</button>";
              echo "            </div>" ;    
              echo "          </div>";
              echo "        </div>";
              echo "      </div>";
              echo "    </div>";
              echo "    </div>";
              echo "   </form>";
              echo "   <form action='delete_data.php' method='post'>
                          <div class='modaldelete' id='modaldelete'>                            
                              <div class='modal-delete'>
                                  <div class='close3' id='close3'>&times;</div>
                                  <div class='modal-delete-confirm'>
                                      <div class='modal-delete-text'>
                                          <h2>Confirm your edited data.</h2><br />
                                          <div id='confirmationDelete' class='confirm-dialog'>
                                            <button id='confirmDeleteYes'>YES</button>  
                                            <button type='button' id='confirmDeleteNo'>CANCEL</button> 
                                          </div>
                                      </div>    
                                  </div>
                              </div>
                          </div>
                      </form>";
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
                                  echo "<b><i>" . $row['w_type'] . " (" . $row['type_desc'] .")</i><br/></b>";
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
                    echo "<a href='browse.php?search=".lcfirst($tag_item)."'>";
                    echo "<li class='cate-btn'><div class='tag_item'>".lcfirst($tag_item)."</div></li>";
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
                    echo "<div id='editModal' class='modal'>";
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

              usort($data, 'compare');

              $data = array_slice($data, 0, 25);
              
              // mysqli_close($con);
              
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
  //Your word not found.
    echo "<p style='font-family: Palanquin Dark, Kanit; font-size: 26px; margin-top: 15px; margin-bottom: 20px;   text-align: center !important;'>Your word not found. <br />";
    echo "<p style='font-family: Palanquin Dark; font-size:18px; margin-left: 15px;'>search for a <a style='color:#FFC300;' href='browse.php?search=" . $searchWord . "'>category</a></p></div>";
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
    
    usort($data, 'compare');

    // Limit the data array to 25 elements
    $data = array_slice($data, 0, 25);
    
    // mysqli_close($con);

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
    
  } 
} else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    //What is the word you want to find?
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

    usort($data, 'compare');
    
    // Limit the data array to 25 elements
    $data = array_slice($data, 0, 25);
    
    // mysqli_close($con);

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

    echo "<div class='RandomWord' style='float: right !important;'>";
    echo "<div class='RandomWord-text'>";
    echo "    <h3>".strtoupper("Random A Vocabulary")."</h3>";
    echo "<button type='button' class='RandomButton' id='RandomButton' onclick='location.reload(true)'>";
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
      echo "<div class='word-detail'>";
      echo "<div class='randomlang-box'>";
      echo "<span style='font-size: 24px;'>$randomLang</span>";
      echo "</div>";
      echo "<div class='RandomWord-header'><a href='explore.php?search=". $randomWord . "&language=". $randomLang . "'>$randomWord</a></div>";
      
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
  }

    ?>
    </section>
    <script>
document.getElementById("file-upload").addEventListener("change", function() {
  const fileInput = document.getElementById("file-upload");
  const fileName = fileInput.files[0].name;
  document.getElementById("file-upload").setAttribute("value", fileName);
});
    
function deleteData() {
    // ส่งค่าไปยังฟังก์ชัน JavaScript ที่เป็นตัวกลางในการลบข้อมูล
    deleteFromDatabase();
}

function deleteFromDatabase() {
    // แสดง confirm dialog เพื่อให้ผู้ใช้ยืนยันการลบ
    var confirmation = confirm("Are you sure you want to delete?");

    // ถ้าผู้ใช้กด Yes
    if (confirmation) {
        // สร้าง form element ใหม่
        var form = document.createElement("form");
        form.method = "POST"; // กำหนด method ของ form เป็น POST
        form.action = "delWord.php"; // กำหนด action ของ form เพื่อส่งไปยัง delWord.php

        // สร้าง input element สำหรับ w_name และกำหนดค่า
        var input_w_name = document.createElement("input");
        input_w_name.type = "hidden"; // กำหนด type ของ input เป็น hidden
        input_w_name.name = "w_name"; // กำหนดชื่อของ input เป็น w_name
        input_w_name.value = "<?php echo $w_name; ?>"; // กำหนดค่าของ input เป็นค่าของตัวแปร $w_name
        form.appendChild(input_w_name); // เพิ่ม input element เข้าไปใน form

        // สร้าง input element สำหรับ w_lang และกำหนดค่า
        var input_w_lang = document.createElement("input");
        input_w_lang.type = "hidden"; // กำหนด type ของ input เป็น hidden
        input_w_lang.name = "w_lang"; // กำหนดชื่อของ input เป็น w_lang
        input_w_lang.value = "<?php echo $w_lang; ?>"; // กำหนดค่าของ input เป็นค่าของตัวแปร $w_lang
        form.appendChild(input_w_lang); // เพิ่ม input element เข้าไปใน form

        // เพิ่ม form เข้าไปใน body ของเอกสาร
        document.body.appendChild(form);

        // ส่ง form
        form.submit();
    }
}

var editBtn = document.getElementById('editbtn');
var modal = document.getElementById('editModal');
var closeModal = document.getElementsByClassName('close')[0];
var updateBtn = document.getElementById('updateModal');
var modal2 = document.querySelector('.modal2');
var playAudioOld = document.getElementById('playAudioOld');
var playAudioNew = document.getElementById('playAudioNew');
var audioCompare = document.getElementById('audioCompare');

// เมื่อคลิกที่ปุ่มแก้ไข โชว์ Modal
editBtn.onclick = function() {
    modal.style.display = "block";
}

// เมื่อคลิกที่ปุ่มปิด Modal
closeModal.onclick = function() {
    modal.style.display = "none";
}

// เมื่อผู้ใช้คลิกพื้นหลังของ Modal จะปิด Modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

window.addEventListener('click', function(event) {
  if (event.target == modal) {
    modal.style.display = 'block'; // หรือ 'flex', 'grid', หรือแสดงแบบอื่น ๆ ตามที่คุณต้องการ
  }
});

// เมื่อคลิกที่ปุ่มปิด Modal2
document.querySelector('.close2').onclick = function() {
    modal2.style.display = "none";
}

// หากคลิกที่ปุ่ม "NO, MY MISTAKE"
document.getElementById('no').onclick = function() {
    modal.style.display = "none";
}

document.getElementById('updateNo').onclick = function() {
    modal2.style.display = "none";
}


editBtn.onclick = function() {
    modal.style.display = "block";
}

///////////////////////Modaldelete///////////////////////////////////

document.addEventListener('DOMContentLoaded', function() {
    var delmodal = document.getElementById('modaldelete');
    var closeDelModal = document.getElementById('close3');

    // เมื่อผู้ใช้คลิกพื้นหลังของ Modal จะปิด Modal
    window.onclick = function(event) {
        if (event.target == delmodal) {
            delmodal.style.display = "none";
        }
    }

    // เมื่อคลิกที่ปุ่มปิด Modaldelete
    closeDelModal.onclick = function() {
        delmodal.style.display = "none";
    }

    // ฟังก์ชันสำหรับแสดง Modaldelete
    window.confirmDelete = function() {
        delmodal.style.display = "block";
    }
});

function confirmDelete() { 
  modaldelete.style.display = "block";
  }

function previewEditInput() { 
  var inputValue = document.getElementById("phonetic").value;
  document.getElementById("editword-new2-phonetic").innerText = inputValue;
  document.getElementById("editphonetic").value = inputValue;

  var inputValue = document.getElementById("ipa").value;
  document.getElementById("editword-new2-ipa").innerText = inputValue;
  document.getElementById("editipa").value = inputValue;

  var inputValue = document.getElementById("w_letter").value;
  document.getElementById("editword-new-letter").innerText = inputValue;
  document.getElementById("editletter").value = inputValue;

  modal2.style.display = "block";
  }

  playAudioOld.style.display = "block";

</script>
  <script src="dictionary.js"></script>
</body>
</html>