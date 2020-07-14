<?php
session_start();

// PHP files
include 'php/db.php';
include 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Přidat produkt</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
  </head>

  <body>

    <!-- Content -->
    <div class="container">
      <h1>Přidat produkt</h1>
      <div class="form">

        <!-- Feedback messages -->
        <p class="error">
          <?php if(!empty($_SESSION['error'])){echo $_SESSION['error'];}?>
        </p>
        <p class="msg">
          <?php if(!empty($_SESSION['msg'])){echo $_SESSION['msg'];}?>
        </p>

        <!-- Add product form -->
        <form action="php/addProcductAction.php" method="post">
          <p>Název produktu</p>
          <input name="productName" value="<?php if(!empty($_SESSION['productName'])){echo $_SESSION['productName'];} ?>"/>

          <p>Popis</p>
          <textarea name="productDescription"><?php if(!empty($_SESSION['productDescription'])){echo $_SESSION['productDescription'];} ?></textarea>

          <p>Cena</p>
          <input name="productPrice" type="number" step="0.01" value="<?php if(!empty($_SESSION['productPrice'])){echo $_SESSION['productPrice'];} ?>"/>

          <p>Kategorie - Vyberte více kategorií přidržením klávesy Ctrl (Windows) nebo Command (Mac)</p>
          <select name="productCategory[]" multiple>
            <?php categoryOptions($db); ?>
          </select>

          <br>
          <br>
          <input type="submit" value="Přidat">
        </form>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
      integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
      crossorigin="anonymous"
    ></script>
    <?php session_destroy(); ?>
  </body>
</html>