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
        <form name="search" method="get" action="browse.php" onsubmit="return validateForm()">
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

      $searchWord = $_GET['search'];

      $tables = array(
        "w_mellas",
        "w_dellin",
        "w_koshehmesh",
        "w_osmeneshien",
        "w_penaluir"
    );
  
    foreach ($tables as $table1) {
      $sql1 = "SELECT * FROM $table1 WHERE tag = '$searchWord'";
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
      $countresult = 0;

      foreach ($data1 as $row2) {
        $key2 = $row2['w_name'] . '-' . $row2['table_name'];
        if (!in_array($key2, $unique_w_names2)) {
          $unique_w_names2[] = $key2;
          if($WHAT > 0) {
            $relative_existed++;
            $WORDC++;
          }
          $WHAT++;
          $countresult++;
        }
      }


        echo "<div class='content-list-word-root'>";
        echo "<div class='content-list-word-container'>";
        echo "<section class='content-list-word content-top' id='mywords'>";
        echo "    <div class='color-white'>";
        if($countresult < 1) {
        echo "<h3>About " . $countresult ." result for <span style='color: #FFC300;'>&#12291;" . $searchWord . "&#12291;</span></h3>";
        } else {
          echo "<h3>About " . $countresult ." results for <span style='color: #FFC300; font-weight: 500;'>&#x0022;" . $searchWord . "&#x0022;</span></h3>";
        }
      // echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";
    
      
      foreach ($data1 as $row1) {
          $key1 = $row1['w_name'] . '-' . $row1['table_name'];      
          if (!in_array($key1, $unique_w_names1)) {
              $unique_w_names1[] = $key1;
              // echo "<span style='float:right'>" . $row1['table_name'] . "</span>";
              echo "<a class='explorelink' style='font-family:Palanquin Dark; font-size: 20px;' href='explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']) . "'>" . $row1['w_name'].  "</a>" . " (".$row1['table_name'].")<br />";
              echo "<div style='font-family:Palanquin Dark; font-size: 20px;'>(" . $row1['w_type'] .  ") " . $row1['mn1'];
              if(!empty($row1['mn2'])) {
                  echo ", " . $row1['mn2'];
              }
              echo "</div>";

              echo "<div style='font-family:Palanquin Dark; font-size: 20px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;'>";
              echo "<a class='browseunderlink' style='font-family:Palanquin Dark; font-size: 18px;' href='explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']) . "'>http://localhost/lexicon/explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']);"</a>";
              echo "</div><br />";
              $relative_existed = 1;
            }
      }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
  } else {
    echo "<span style='color: white; margin-left: 60px; font-family:Palanquin Dark; font-size: 20px;'><i>No results found.</i></span>"; 
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

