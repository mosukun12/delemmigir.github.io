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
        .table-vocab {
          font-family: arial, kanit;
          border-collapse: collapse;
          width: 100%;
          table-layout: fixed;
        }
        
        .table-vocab i{
          margin-left: 5px; 
          font-family: 'NewtonC Regular';
        }

        .table-vocab a{
          color: #FFC300;
          text-decoration: none;
        }

        .table-vocab a:hover{
          color: #ffd859;
          text-decoration: none;
        }

        .table-vocab th {
          text-align: center;
        }
        
        td, th {
          border: 1px solid transparent;
          text-align: left;
          /* padding: 8px; */
          vertical-align: top;
        }
     
        /* tr:nth-child(odd) {
          background-color: #353535;
        } */

        tr:nth-child(even) {
          background-color: #282828;
        }

        .letter {
          font-family: Mellas-Regular;
          font-size: 20px;
        }
      </style>
  </head>
  <body>
    <?php include("include_header.html"); ?>
    <div class="container">
      <section class="dict-root">
        <div class="dict-selectlang">
          <div class="dict-selectlang-frame">
            <form name="language" method="get" action="dictionary.php">
              <div class="site-lang-select-list">
                <input type="radio" name="language" value="dellin" id="dellinSelect" <?php if(!isset($_GET['language'])) echo 'checked'; ?> <?php if(isset($_GET['language']) && $_GET['language'] == 'dellin') echo 'checked'; ?>>
                <label for="dellinSelect" onclick="select('dellin')"><span class="language-name">Dellin</span></label><br>
                    
                <input type="radio" name="language" value="mellas" id="mellasSelect" <?php if(isset($_GET['language']) && $_GET['language'] == 'mellas') echo 'checked'; ?>>
                <label for="mellasSelect" onclick="select('mellas')"><span class="language-name">Mellas</span></label><br>
                    
                <input type="radio" name="language" value="koshehmesh" id="koshehmeshSelect" <?php if(isset($_GET['language']) && $_GET['language'] == 'koshehmesh') echo 'checked'; ?>>
                <label for="koshehmeshSelect" onclick="select('koshehmesh')"><span class="language-name">Koshehmesh</span></label><br>
                    
                <input type="radio" name="language" value="penaluir" id="penaluirSelect" <?php if(isset($_GET['language']) && $_GET['language'] == 'penaluir') echo 'checked'; ?>>
                <label for="penaluirSelect" onclick="select('penaluir')"><span class="language-name">Penaluir</span></label><br>
                    
                <input type="radio" name="language" value="osmeneshien" id="osmeneshienSelect" <?php if(isset($_GET['language']) && $_GET['language'] == 'osmeneshien') echo 'checked'; ?>>
                <label for="osmeneshienSelect" onclick="select('osmeneshien')"><span class="language-name">Osmeneshien</span></label><br>
              </div>
            </form>
          </div>
        </div>
        <div class="dict-list-container">
          <div class="dict-list-table">
            <?php
              include("connect.php");
              if (isset($_GET['language'])) {
                $lang = $_GET["language"];
                $table = "w_" . $lang;
                $sql = "SELECT * FROM $table";
                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      $row['table_name'] = ucfirst(str_replace('w_', '', $table));
                      $data[] = $row;
                  }
                }
                // echo "<div class='table-vocab'";
                echo "<table class='table-vocab'>";
                echo "<tr>";
                echo "<th>WORD</th>";
                echo "<th>IPA</th>";
                echo "<th>LETTER</th>";
                echo "<th>MEANING</th>";
                echo "</tr>";
                if (!empty($data)) {
                  foreach ($data as $row) {
                  echo "<tr>";
                  echo "<th><b><a href='explore.php?search=" . $row['w_name'] . "&language=". $lang . "'>".$row['w_name'] . "</a></b><i> " .$row['w_type']."</i></th>";
                  echo "<th>".$row['ipa']."</th>";
                  echo "<th><div class='letter'>".$row['w_letter']."</div></th>";
                  // echo "<span style='font-family: UKIJ Nasq Zilwa Bold, kanit;'>";
                  echo "<th>".$row['mn1']."</th>";
                  // echo "</span>";
                  echo "</tr>";
                  }
                }
                echo "</table>";
                // echo "</div> ";
              }
              //  else {
              //   echo "<div style=\"display: flex; justify-content: center; align-items: center;\"><div style=\"text-align: center; display: flex; justify-content: center; align-items: center;\">Please, select a language.</div></div>";
              // }
            ?>
          </div>
        </div>
      </section>
    </div>
<script>

window.onload = function() {
    if (!<?php echo isset($_GET['language']) ? 'true' : 'false'; ?>) {
        select('dellin');
    }
};

function select(lang) {
    var linkURL = "dictionary.php?language=" + lang;
    window.location.href = linkURL;
}
</script>
    <script src="dictionary.js"></script>
  </body>
  </html>
