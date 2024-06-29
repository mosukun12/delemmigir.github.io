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
            <div class="browse-site-search-container2">
              <input type="search" class="site-searchbar2" id="search" name="search" placeholder="Search" 
              <?php 
              if(isset($_GET['search'])) {
                echo "value=\"".$_GET["search"]."\"";
              }
              ?>
              />
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

      if(isset($_GET['search'])) {
        $searchWord = $_GET['search'];
      } else {
        $searchWord = "";
      }
      
      $tables = array(
        "w_mellas",
        "w_dellin",
        "w_koshehmesh",
        "w_osmeneshien",
        "w_penaluir"
    );
  
    foreach ($tables as $table1) {
      $sql1 = "SELECT * FROM $table1 WHERE tag = '$searchWord' ORDER BY date";
      $result1 = mysqli_query($con, $sql1);
    
      if (mysqli_num_rows($result1) > 0) {
          while ($row1 = mysqli_fetch_assoc($result1)) {
              $row1['table_name'] = ucfirst(str_replace('w_', '', $table1));
              $data1[] = $row1;
          }
      }
    }

    foreach ($tables as $table2) {
      $sql2 = "SELECT * FROM $table2 WHERE tag LIKE '%$searchWord%' ORDER BY date";
      $result2 = mysqli_query($con, $sql2);
        if (mysqli_num_rows($result2) > 0) {
          while ($row2 = mysqli_fetch_assoc($result2)) {
              $row2['table_name'] = ucfirst(str_replace('w_', '', $table2));
              $data2[] = $row2;
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
        if($countresult < 2) {
        echo "<h3>About " . $countresult ." result for <span style='color: #FFC300;'>&quot;" . $searchWord . "&quot;</span></h3>";
        echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Category</a></span></h4>";
      } else {
          echo "<h3>About " . $countresult ." results for <span style='color: #FFC300; font-weight: 500;'>&quot;" . $searchWord . "&quot;</span></h3>";
          echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Category</a></span></h4>";
        }
      // echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";
    
      
      foreach ($data1 as $row1) {
          $key1 = $row1['w_name'] . '-' . $row1['table_name'];      
          if (!in_array($key1, $unique_w_names1)) {
              $unique_w_names1[] = $key1;
              // echo "<span style='float:right'>" . $row1['table_name'] . "</span>";
              echo "<a class='explorelink' style='font-family:arial; font-size: 20px;' href='explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']) . "'>" . $row1['w_name'].  "</a>" . " (".$row1['table_name'].")<br />";
              echo "<div style='font-family:arial; font-size: 20px;'><i>(" . $row1['w_type'] .  ") </i>" . $row1['mn1'];
              if(!empty($row1['mn2'])) {
                  echo ", " . $row1['mn2'];
              }
              echo "</div>";

              echo "<div style='font-family:arial; font-size: 20px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;'>";
              echo "<a class='browseunderlink' style='font-family:arial; font-size: 18px;' href='explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']) . "'>http://localhost/lexicon/explore.php?search=" . $row1['w_name'] . "&language=". lcfirst($row1['table_name']);"</a>";
              echo "</div><br />";
              $relative_existed = 1;
            }
      }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
  } else if (!empty($data2)) {
    $unique_w_names1 = array();
    $unique_w_names2 = array();
    $relative_existed = 0;
    $WHAT = "";
    $WORDC = "";
    $countresult = 0;

    foreach ($data2 as $row2) {
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
      if($countresult < 2) {
      echo "<h3>About " . $countresult ." result for <span style='color: #FFC300;'>&quot;" . $searchWord . "&quot;</span></h3>";
      echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Category</a></span></h4>";
    } else {
        echo "<h3>About " . $countresult ." results for <span style='color: #FFC300; font-weight: 500;'>&quot;" . $searchWord . "&quot;</span></h3>";
        echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Category</a></span></h4>";
      }
    // echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";
  
    
    foreach ($data2 as $row2) {
        $key2 = $row2['w_name'] . '-' . $row2['table_name'];      
        if (!in_array($key2, $unique_w_names1)) {
            $unique_w_names1[] = $key2;
            // echo "<span style='float:right'>" . $row2['table_name'] . "</span>";
            echo "<a class='explorelink' style='font-family:arial; font-size: 20px;' href='explore.php?search=" . $row2['w_name'] . "&language=". lcfirst($row2['table_name']) . "'>" . $row2['w_name'].  "</a>" . " (".$row2['table_name'].")<br />";
            echo "<div style='font-family:arial; font-size: 20px;'><i>(" . $row2['w_type'] .  ") </i>" . $row2['mn1'];
            if(!empty($row2['mn2'])) {
                echo ", " . $row2['mn2'];
            }
            echo "</div>";

            echo "<div style='font-family:arial; font-size: 20px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;'>";
            echo "<a class='browseunderlink' style='font-family:arial; font-size: 18px;' href='explore.php?search=" . $row2['w_name'] . "&language=". lcfirst($row2['table_name']) . "'>http://localhost/lexicon/explore.php?search=" . $row2['w_name'] . "&language=". lcfirst($row2['table_name']);"</a>";
            echo "</div><br />";
            $relative_existed = 1;
          }
    }
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  } else { //if ตัวที่สองหากหา Category ไม่พบ

    $searchWord = $_GET['search'];

    $tables = array(
      "w_mellas",
      "w_dellin",
      "w_koshehmesh",
      "w_osmeneshien",
      "w_penaluir"
  );

  foreach ($tables as $table) {
    $sql = "SELECT * FROM $table WHERE w_name = '$searchWord' ORDER BY date";
    $result = mysqli_query($con, $sql);
  
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['table_name'] = ucfirst(str_replace('w_', '', $table));
            $data[] = $row;
        }
    }
  }

  foreach ($tables as $table1) {
    $sql1 = "SELECT * FROM $table1 WHERE tag LIKE '%$searchWord%' ORDER BY date";
    $result1 = mysqli_query($con, $sql1);
      if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $row1['table_name'] = ucfirst(str_replace('w_', '', $table1));
            $data1[] = $row1;
        }
    }
  }

  $countresult = 0;
  if (!empty($data)) {
    $unique_w_names1 = array();
    $unique_w_names2 = array();
    $relative_existed = 0;
    $WHAT = "";
    $WORDC = "";
    $wordrow = "";

    foreach ($data as $row) {
      $key = $row['w_name'] . '-' . $row['table_name'];
      if (!in_array($key, $unique_w_names1)) {
        $unique_w_names[] = $key;
        if($WHAT > 0) {
          $relative_existed++;
          $WORDC++;
        }
        $WHAT++;
        $countresult++;
      }
    }
    
    if(isset($data)) {
      foreach ($data as $row4) {
        $key4 = $row4['w_name'] . '-' . $row4['table_name'];
        if (!in_array($key4, $unique_w_names2)) {
          $unique_w_names2[] = $key4;
        }
      }
    }
    
    $count_duplicates = count($unique_w_names2) - 1;
    
    foreach ($data as $row) {
      $wordrow++;
      $countresult = count($unique_w_names2);
    }    

  }
      echo "<div class='content-list-word-root'>";
      echo "<div class='content-list-word-container'>";
      echo "<section class='content-list-word content-top' id='mywords'>";
      echo "    <div class='color-white'>";
      if(!isset($data)) {
        echo "<h3>No results for <span style='color: #FFC300; font-weight: 500;'>&quot;" . $searchWord . "&quot;</span></h3>";
        echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Name</a></span> without selected language</h4>";
      } else if($countresult < 2)  {
        echo "<h3>About " . $countresult ." result for <span style='color: #FFC300;'>&quot;" . $searchWord . "&quot;</span></h3>";
        echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Name</a></span> without selected language</h4>";
      } else {
        echo "<h3>About " . $countresult ." results for <span style='color: #FFC300; font-weight: 500;'>&quot;" . $searchWord . "&quot;</span></h3>";
        echo "<h4>Search by <span><a style='color: #FFC300;' href='category.php'>Name</a></span> without selected language</h4>";
      }
    // echo "    <span style='float:left; font-weight: 500; opacity: 70%;'>Vocab</span><span style='float:right; font-weight: 500; opacity: 70%;'>Language</span><br />";
    
    if(isset($data)) {
    foreach ($data as $row) {
        $key = $row['w_name'] . '-' . $row['table_name'];      
        if (!in_array($key, $unique_w_names1)) {
            $unique_w_names1[] = $key;
            // echo "<span style='float:right'>" . $row['table_name'] . "</span>";
            echo "<a class='explorelink' style='font-family:arial; font-size: 20px;' href='explore.php?search=" . $row['w_name'] . "&language=". lcfirst($row['table_name']) . "'>" . $row['w_name'].  "</a>" . " (".$row['table_name'].")<br />";
            echo "<div style='font-family:arial; font-size: 20px;'><i>(" . $row['w_type'] .  ") </i>" . $row['mn1'];
            if(!empty($row['mn2'])) {
                echo ", " . $row['mn2'];
            }
            echo "</div>";
            echo "<div style='font-family:arial; font-size: 20px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;'>";
            echo "<a class='browseunderlink' style='font-family:arial; font-size: 18px;' href='explore.php?search=" . $row['w_name'] . "&language=". lcfirst($row['table_name']) . "'>http://localhost/lexicon/explore.php?search=" . $row['w_name'] . "&language=". lcfirst($row['table_name']);"</a>";
            echo "</div><br />";
            $relative_existed = 1;
          }
    }
   }
  } 
  // else {
  //   echo "<span style='color: white; margin-left: 60px; font-family:Palanquin Dark; font-size: 20px;'><i>No results found.</i></span>"; 
  //   echo "</div>";
  //   echo "</div>";
  //   echo "</div>";
  //   echo "</div>";
  // }
    ?>
    </section>
  <script src="dictionary.js"></script>
</body>
</html>

