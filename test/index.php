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
                <form name="language" method="get" action="explore.php">
                <div class="site-lang-select-list">
                    <input type="radio" name="language" value="dellin" id="dellinSelect" required>
                    <label for="dellinSelect"><span class="language-name">Dellin</span></label><br>
                    <input type="radio" name="language" value="mellas" id="mellasSelect" required>
                    <label for="mellasSelect"><span class="language-name">Mellas</span></label><br>
                    <input type="radio" name="language" value="koshehmesh" id="koshehmeshSelect" required>
                    <label for="koshehmeshSelect"><span class="language-name">Koshehmesh</span></label><br>
                    <input type="radio" name="language" value="penaluir" id="penaluirSelect" required>
                    <label for="penaluirSelect"><span class="language-name">Penaluir</span></label><br>
                    <input type="radio" name="language" value="osmeneshien" id="osmeneshienSelect" required>
                    <label for="osmeneshienSelect"><span class="language-name">Osmeneshien</span></label><br>
                </div>
                <div class="site-search-container">
                    <input type="search" class="site-searchbar" id="search" name="search" placeholder="Search" />
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>