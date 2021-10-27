<?php
require(dirname(__DIR__) . "/php/functions/startSession.php");

$isset = isset($_COOKIE[session_name()]);

if (!$isset || ($isset && $_SESSION['status'] == 'user')) header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" href="../imgs/logo.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/form.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <title>TechZone | Editar produto</title>
  </head>
  <body>
    <?php require_once(dirname(__DIR__) . "/components/header.php"); ?>
    <main>
      <div class="container-xl px-1 py-5 mx-auto">
          <div class="row d-flex justify-content-center">
              <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                <?php require_once(dirname(__DIR__) . "/components/productForm.php"); ?>
              </div>
          </div>
      </div>
    </main>
    <?php require_once(dirname(__DIR__) . "/components/footer.php"); ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
      crossorigin="anonymous"
    ></script>
    <script src="https://kit.fontawesome.com/d367c40667.js" crossorigin="anonymous"></script>
    <script src="../js/validate.js"></script>
    <script src="../js/CPFMask.js"></script>
    <script src="../js/revealPass.js"></script>
    <script src="../js/toggleLogin.js"></script>
  </body>
</html>