<?php
require(__DIR__ . "/php/functions/startSession.php");
require(__DIR__ . "/php/functions/autoLoad.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" href="imgs/logo.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/login.css" />
    <title>TechZone</title>
  </head>
  <body>
    <?php require_once(__DIR__ . "/components/header.php"); ?>
    <main>
      <?php require_once(__DIR__ . "/components/login.php"); ?>
      <div id="cards">
        <?php require_once(__DIR__ . "/php/functions/loadProducts.php"); ?>
      </div>
    </main>
    <?php require_once(__DIR__ . "/components/footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
      crossorigin="anonymous"
    ></script>
    <script src="js/toggleLogin.js"></script>
  </body>
</html>