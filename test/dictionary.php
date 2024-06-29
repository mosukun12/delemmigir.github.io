<?php session_start(); ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
      <title>Dictionary</title>
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
      <style>
        .show {
          display: inline-block;
        }
        .hide {
          display: none;
        }
      </style>
  </head>
  <body>
    <?php include("include_header.html"); ?>
    <div class="sec-side-frame">
      <section class="sec-side-root">
        <div class="search-by-category" id="searchByCategory">
          <label for="SearchCategory">Search by category</label>
          <div class="search-by-category-toggle-switch-showhide">
            <button class="showHide-frame" onclick="show()"> 
              <div class="show">show</div>
              <i class="arrow up"></i>
            </button>
          </div>
        </div>
        <div class="category-form" id="category" style="display: none;">
        <form action="dictionary.php" method="get" id="searchForm">
          <select id="tag-input" class="input-box-tag" name="tag[]" multiple></select>
            <button class="clear" id="tag-input-clear" onclick="resetInput('tag-input')" style="display: none;"><img src="images/cancel-icon.png" class="clearicon"></button><br />
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
            <!-- <input type="submit" value="submit" name="cat-submit"/> -->
        </div>
        <div class="filter-root">
          <div class="filter-head">
            <i class="fa fa-filter"></i>
            <label class="filterSelect">Filter</label>
          </div>
          <div class="segmented-control">
            <input type="radio" id="option1" name="segmented1" value="begins-with">
            <label for="option1" name="option1">Begins with</label>
            <input type="radio" id="option2" name="segmented1" value="ends-with">
            <label for="option2">Ends with</label>
            <input type="radio" id="option3" name="segmented1" value="none" checked>
            <label for="option3" class="close-icon" name="close"></label>
          </div>
          <div class="segmented-control">
            <input type="radio" id="option4" name="segmented2" value="vocab">
            <label for="option4" name="option4">Vocab</label>
            <input type="radio" id="option5" name="segmented2" value="meaning">
            <label for="option5">Meaning</label>
            <input type="radio" id="option6" name="segmented2" value="none" checked>
            <label for="option6" class="close-icon" name="close"></label> 
          </div>
          <hr class="hr-1" />
          <div class="language-root">
            <label class="langSelectLabel" id="seeMore">Language</label>
            <select name="lang" id="langSelect" onchange="sendDataLang()">
                <option <?php if(empty($_GET['lang'])) { echo "any"; }?> hidden value="">Any</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "any")) { echo "selected"; }}?> value="">Any</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "dellin")) { echo "selected"; }}?> value="dellin" name="dellin">Dellin</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "mellionian")) { echo "selected"; }}?> value="melionian" name="melionian">Melionian</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "mellas")) { echo "selected"; }}?> value="mellas" name="mellas">Mellas</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "olundus")) { echo "selected"; }}?> value="olundus" name="olundus">Olundus</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "omeneshien")) { echo "selected"; }}?> value="osmeneshien" name="osmeneshien">Osmeneshien</option>
                <option <?php if(isset($_GET['lang'])) {if(($_GET['lang'] == "penaluir")) { echo "selected"; }}?> value="penaluir" name="penaluir">Penaluir</option>
            </select>
              <input type="submit" class="submitCircle" name="submitCircle" value="&#10004"></button>
            <hr class="hr-1" />
            <div class="type-root">
              <label class="typeSelectLabel">Part of speech</label>
              <button type="button" id="typeSelectAllBtn" onclick="checkAll('typeSelect')">Select All</button><br>
              <!-- <form action="" method="get" id="typeSelect"> -->
                <input type="checkbox" class="typeSelect" id="typeSelect1" name="typeSelect1" value="Abbreviation">
                <label for="typeSelect1">Abbreviation</label><br>
                <input type="checkbox" class="typeSelect" id="typeSelect2" name="typeSelect2" value="Adjective">
                <label for="typeSelect2">Adjective</label><br>
                <input type="checkbox" class="typeSelect" id="typeSelect3" name="typeSelect3" value="Adverb">
                <label for="typeSelect3">Adverb</label><br>
                <input type="checkbox" class="typeSelect" id="typeSelect4" name="typeSelect4" value="Conjunction">
                <label for="typeSelect4">Conjunction</label><br>
                <div class="typeSelect-seemore" id="typeSelectMore" style="display: none;">
                  <input type="checkbox" class="typeSelect" id="typeSelect5" name="typeSelect5" value="Feminine">
                  <label for="typeSelect5">Feminine</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect6" name="typeSelect6" value="Interjection">
                  <label for="typeSelect6">Interjection</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect7" name="typeSelect7" value="Masculine">
                  <label for="typeSelect7">Masculine</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect8" name="typeSelect8" value="Name">
                  <label for="typeSelect8">Name</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect9" name="typeSelect9" value="Noun">
                  <label for="typeSelect9">Noun</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect10" name="typeSelect10" value="Past participle">
                  <label for="typeSelect10">Past participle</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect11" name="typeSelect11" value="Plural">
                  <label for="typeSelect11">Plural</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect12" name="typeSelect12" value="Prefix">
                  <label for="typeSelect12">Prefix</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect13" name="typeSelect13" value="Preposition">
                  <label for="typeSelect13">Preposition</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect14" name="typeSelect14" value="Pronoun">
                  <label for="typeSelect14">Pronoun</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect15" name="typeSelect15" value="Pronominal">
                  <label for="typeSelect15">Pronominal</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect16" name="typeSelect16" value="Suffix">
                  <label for="typeSelect16">Suffix</label><br>
                  <input type="checkbox" class="typeSelect" id="typeSelect17" name="typeSelect17" value="Verb">
                  <label for="typeSelect17">Verb</label><br>
                </div>
              <!-- </form> -->
              <div class="typeSelect-seemore">
                <button type="button" class="seeMore" onclick="showType()">
                  <div class="showMore2">see more⠀<i class="arrow-filter up-filter"></i></div>
                </button>
            </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <section class="sec-top-root">
      <div class="sec-top-container">
        <!-- <form name='searchbar' action="" method="get"> -->
          <div class="searchbar-container">
            <input type="search" class="searchbar" id="searchbar" name="searchbar" placeholder="Find vocabulary or keyword..." />
            <div class="searching">
              <button class="searching-circle" id="searching-circle" onclick="search">
                <img src="images/search.png" class="searchingicon">
              </button><br />
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
            <div class="segmented-control-group wordlist-tab">
              <input type="radio" id="block" name="segmented3" value="block" checked>
                <label for="block" name="block">
                  <img src="images/block.png" class="sortlayout">
                </label>
              <input type="radio" id="row" name="segmented3" value="row">
                <label for="row" name="row">
                  <img src="images/row.png" class="sortlayout">
                </label>
            </div>
          </div>
          </div>
        </form>                  
      </div>
    </section>
    <section class="content-list-main-container">
    <div id="display"></div>
        <?php
$con = mysqli_connect("localhost", "root", "", "lexicon");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");

if (!empty($_GET['lang'])) {
  $table = "w_" . $_GET['lang'];
} else {
  $tables = array(
    "w_mellas",
    "w_dellin",
    "w_melionian",
    "w_olundus",
    "w_osmeneshien",
    "w_penaluir"
  );
  $table = implode(', ', $tables);
}

$data = array();
if (isset($_GET['searchbar'])) {
  $searchWord = mysqli_real_escape_string($con, $_GET['searchbar']);
}

  function compare($a, $b) {
    return strtotime($a['date']) < strtotime($b['date']);
  }

if (!empty($_GET['lang'])) {
  if (isset($_GET['searchbar'])) {
    $sql = "SELECT * FROM $table WHERE w_name = '$searchWord'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $row['table_name'] = ucfirst(str_replace('w_', '', $table));
          $data[] = $row;
      }
    }
  } else {
    $sql = "SELECT * FROM $table WHERE w_name";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $row['table_name'] = ucfirst(str_replace('w_', '', $table));
          $data[] = $row;
      }
    }
  }
} elseif (empty($_GET['searchbar'])) {
  foreach ($tables as $table) {

    $sql = "SELECT * FROM $table";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $row['table_name'] = ucfirst(str_replace('w_', '', $table));
          $data[] = $row;
      }
    }

  }
} elseif (!empty($searchWord)) {
    foreach ($tables as $table) {

      $sql = "SELECT * FROM $table WHERE w_name = '$searchWord'";
      $result = mysqli_query($con, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['table_name'] = ucfirst(str_replace('w_', '', $table));
            $data[] = $row;
        }
      }

    }
  } else  {
    foreach ($tables as $table) {

      $sql = "SELECT * FROM $table";
      $result = mysqli_query($con, $sql);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['table_name'] = ucfirst(str_replace('w_', '', $table));
            $data[] = $row;
        }
      }

    }
}

  usort($data, 'compare');

  $data = array_slice($data, 0, 25);

  if (!empty($data)) {
    foreach($data as $row) {
    $w_id = $row['w_id'];
    echo "<div style='color: red; font-size: 20px;'>".$row['w_lang'] . $row['w_id']."</div>";
      echo "<div class='content-list-word-root'>";
      echo "<div class='lang-top'>" . ucfirst($row['w_lang']) . "</div>";
      echo "<div class='content-list-word-container'>";
      echo "<section class='content-list-word content-top' id='mywords'>";
      echo "<div class='content-word-item' id='word" . $row['w_id'] . "'>";
      echo "<p class='wordname' id='wordName" . $row['w_id'] . "'>" . $row['w_name'] . "</p><h2 class='wordredt'>(". $row['w_redt'] . ")</h2>";

      if (!empty($row['phonetic'])) {
        if (!empty($row['phonetic']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
          echo "<p class='wordphonetic' id='wordPhonetic". $row['w_id'] ."'>[" . $row['phonetic'] . "]</p>";
        } else {
            echo "<p class='wordphonetic' id='wordPhonetic". $row['w_id'] ."'>" . $row['phonetic'] . "</p>";
          }
        } elseif (!empty($row['ipa'])) {
          if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
          echo "<p class='wordipa' id='wordIPA". $row['w_id'] ."'>[" . $row['ipa']. "]</p>";
          } else { 
            echo "<p class='wordipa' id='wordIPA". $row['w_id'] ."'>" . $row['ipa']. "</p>";
            }
        }
        if (!empty($row['ipa'])) {
          if (!empty($row['ipa']) && strpos($row['phonetic'], '[') !== 0 && substr($row['phonetic'], -1) !== ']') {
          echo "<p class='wordipa hide' id='wordIPA". $row['w_id'] ."'>[" . $row['ipa']. "]</p>";
          } else {
            echo "<p class='wordipa hide' id='wordIPA". $row['w_id'] ."'>" . $row['ipa']. "</p>";
          }
        }

      if (!(empty($row['ipa'])) && !(empty($row['phonetic']))) {
      echo "<button class='changeWordIPA' onclick='changeWordIPA". $row['w_lang'] . $row['w_id'] ."()'>";
      echo "<div class='showIPA'>SHOW IPA</div>";
      echo "</button>";
      }

      if (!empty($row['audio'])) {
      echo "<audio id='pronounce" . $row['w_lang'] . $row['w_id'] . "' class='display: none; visibility:hidden; hide'>";
      echo "<source src='audio/". $row['audio'] . "' type='audio/mp3'>";
      echo "Your browser does not support the audio element.";
      echo "</audio>";
      echo "<button class='audio-btn' onclick='playAudio" . $row['w_lang'] . $row['w_id']."()'><img src='images/Speaker_Icon.png'></button>";
    }
      if (!empty($row['w_letter'])) {
      echo "<p class='wordLangLetter' id='wordLanguage'>(" . $row['w_letter'] . ")</p>";
    }
      echo "<div class='buttonsetting'>";
      echo "<button id='editbtn' class='editbtn'><i class='fa fa-pencil'></i></button>";
      echo "<button id='deletebtn" . $row['w_lang'] . $row['w_id'] . "' class='deletebtn'><i class ='fa fa-trash'></i></button>";
      echo "     <form name='delete' method='get' action='dictionary.php'>";
      echo "        <input type='text' name='table' value='w_" . $row['w_lang'] . "' hidden/>";
      echo "        <input type='text' name='w_id' value='" . $row['w_id'] . "' hidden/>";
      echo "        <input type='text' name='w_name' value='" . $row['w_name'] . "' hidden/>";
      echo "        <input type='text' name='w_lang' value='" . $row['w_lang'] . "' hidden/>";
      echo "        <input type='text' name='w_type' value='" . $row['w_type'] . "' hidden/>";
      echo "        <input type='text' name='uniqueid' value='" . $row['w_lang'].$row['w_name'].$row['w_type'] . "' hidden/>";
      echo "<div id='deleteModal" . $row['w_lang'] . $row['w_id'] . "' class='modal'>";
      echo "  <!-- Modal content -->";
      echo "  <div class='modal-content'>";
      echo "    <span class='close'>&times;</span>";
      echo "      <span class='sureornot'>ARE YOU SURE TO DELETE THESE DATA?". $row['w_lang'].$row['w_name'].$row['w_type'] ."</span>";
      echo "    <div class='confirm-delete'>";
      echo "     <button type='submit' class='yes' value='YES, DELETE' onclick='delWord" . $row['w_lang'] . $row['w_id'] . "()'><div class='delete-text'>YES, DELETE</div></button>";
      echo "     </form>";
      echo "     <button type='button' class='no' id='no' onclick='delWord" . $row['w_lang'] . $row['w_id'] . "()'><div class='delete-text'>NO, MY MISTAKE</div></button>";
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
      if ($row['mn1'] != null) {
        echo   "<ol class='meaning-list'>";
        echo    "<li class='meaning-list-content'>" . $row['mn1'] . "</li>";
        if ($row['ex1'] != null) {
          echo    "<div class='example-sentence'>";
          echo      "<p>". $row['ex1'] . "<br>";
          echo    "</div>";
        } 
      } else {
        echo "<div style='color: gray; font-family: kanit; font-size: 18px; font-style:italic;'>(no data)</div>";
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
      echo   "</ol>";
      echo   "<div class='recentAndCreated'>";
      echo     "<p>Last edited: " . $row['latest_edited'] . "</p>";
      echo     "<p>Create date: " . $row['date'] . "</p>";
      echo   "</div>";
      echo   "<hr>";
      echo   "<div class='category-list'>";
      echo     "<div class='cat-title'>CATEGORY:</div>";
      if ($row['tag'] != null) {
        echo     "<ul class='category-list-content'>";
        $tag = $row['tag'];
        $individual_tags = explode(',', $tag);

        foreach ($individual_tags as $tag_item) {
            echo "<li class='cate-box'>$tag_item</li>";
        }

        $remaining_li = max(0, 1 - count($individual_tags));
        for ($i = 0; $i < $remaining_li; $i++) {
            echo "<li class='cate-box'></li>";
        }
      } else {
        echo "<li class='cate-box-none'>NONE</li>";
      }
      echo     "</ul>";
      echo   "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  } else {
    echo "<div class='content-list-word-root'>";
    echo "<div class='content-list-word-container'>";
    echo "<section class='content-list-word content-top' id='mywords'>";
    echo "<div class='content-word-item' id='word'>";
    echo "<p style='font-family: Palanquin Dark, Kanit; font-size: 26px; margin-top: 0px; margin-bottom: 20px;'>No results</p>";
    echo "</div>";
    echo "</section>";
    echo "</div>";
    echo "</div>";
  }

  //DELETING ZONE
  if (isset($_GET['delete'])) {
    if(isset($_GET['w_id']) && isset($_GET['table'])) {
        $w_id = mysqli_real_escape_string($con, $_GET['w_id']);
        $table = mysqli_real_escape_string($con, $_GET['table']);

        // ทำการลบข้อมูลตามตารางและ ID ที่ระบุ
        $sql = "DELETE FROM $table WHERE w_id = '$w_id'";
        $result = mysqli_query($con, $sql);

        // เช็คว่าลบข้อมูลสำเร็จหรือไม่
        if ($result) {
            echo "<script>alert('Delete Successful');</script>";
        } else {
            echo "<script>alert('Error deleting data');</script>";
        }
    }
}

  mysqli_close($con);
  ?>
    </section>
  <script>

  <?php foreach($data as $row): ?>
    function changeWordIPA<?php echo $row['w_lang'] . $row['w_id']; ?>() {
        var phonetic = document.getElementById('wordPhonetic<?php echo $row['w_id']; ?>');
        var ipa = document.getElementById("wordIPA<?php echo $row['w_id']; ?>");
        var showIPAButton = document.querySelector('.showIPA');

        if (phonetic.classList.contains("hide")) {
            phonetic.classList.remove("hide");
            ipa.classList.add("hide");
            showIPAButton<?php echo $row['w_id']; ?>.innerHTML = 'SHOW IPA';
        } else {
            phonetic.classList.add("hide");
            ipa.classList.remove("hide");
            showIPAButton<?php echo $row['w_id']; ?>.innerHTML = 'PHONETIC SPELLING';
        }
    }

    var audio<?php echo $row['w_lang'] . $row['w_id']; ?> = document.getElementById('pronounce<?php echo $row['w_lang'] . $row['w_id']; ?>'); // Ensure correct ID usage
    var isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?> = false;

    function playAudio<?php echo $row['w_lang'] . $row['w_id']; ?>() {
      if (!isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?>) {
        isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?> = true;
        audio<?php echo $row['w_lang'] . $row['w_id']; ?>.play(); // Ensure correct audio element usage
        audio<?php echo $row['w_lang'] . $row['w_id']; ?>.addEventListener('ended', function() {
          isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?> = false;
        });
      } else {
        audio<?php echo $row['w_lang'] . $row['w_id']; ?>.pause();
        audio<?php echo $row['w_lang'] . $row['w_id']; ?>.currentTime = 0;
        isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?> = false;
      }
    }

    audio<?php echo $row['w_lang'] . $row['w_id']; ?>.addEventListener('ended', function() { // Ensure correct event listener attachment
      audio<?php echo $row['w_lang'] . $row['w_id']; ?>.pause();
      isPlaying<?php echo $row['w_lang'] . $row['w_id']; ?> = false;
    });

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


<?php endforeach; ?>

</script>
    <script src="dictionary.js"></script>
  </body>
  </html>
