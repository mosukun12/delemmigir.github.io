<?php
include("connect.php");

if(isset($_GET['language'])) {
$language = mysqli_real_escape_string($con, $_GET['language'] ); 
}
if(isset($_GET['search'])) {
$searchWord = mysqli_real_escape_string($con, $_GET['search']);
}

$tables = array(
    "w_mellas",
    "w_dellin",
    "w_koshehmesh",
    "w_osmeneshien",
    "w_penaluir"
);

  $data = array();
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

  if (!empty($data)) {
    foreach ($data as $row) {
        if(isset($searchWord) && isset($language)) {
            echo "<form id='autoSubmitForm' name='language' method='get' action='explore.php'>";
            echo "<input type='text' name='language' value='".  $language . "' hidden>";
            echo "<input type='search' id='search' name='search' value='". $searchWord ."' hidden/>";
            echo "</form>";
        } else {
            echo "<form id='autoSubmitForm' name='search' method='get' action='browse.php'>";
            echo "<input type='search' id='search' name='search' value='". $searchWord ."' hidden/>";
            echo "</form>";
        }
    }
  } else {
    echo "<form id='autoSubmitForm' name='search' method='get' action='browse.php'>";
    echo "<input type='search' id='search' name='search' value='". $searchWord ."' hidden/>";
    echo "</form>";
  }


  mysqli_close ($con);
?>

<script type="text/javascript">
    window.onload = function() {
        document.getElementById('autoSubmitForm').submit();
    }
</script>