<?php
$authError = isset($_GET['authError']) && $_GET['authError'];
$internalLogError = isset($_GET['internalLogError']) && $_GET['internalLogError'];
$display = $authError || $internalLogError ? 'block' : 'none';
?>

<div class="form-popup" id="myForm" style="display: <?php echo $display; ?>;">
  <form action="../../php/handlers/handleLogin.php" class="form-container" method="POST">
    <?php
    if ($internalLogError)
    {
      echo "<div style='color: red;'>
      <h2>Ops... Algo deu errado!</h2>
      <p>Ocorreu um erro no servidor. Tente novamente mais tarde.</p>
      </div>";
    }
    elseif ($authError)
    {
      echo "<div style='color: red;'>
      <h2>Ops... Algo deu errado!</h2>
      <p>Credenciais incorretas!</p>
      </div>";
    }
    ?>
    <h1 class=h1color-a>Login</h1>

    <label class="email" for="email"><b><span>&#9993;</span>Email</b></label><br />
    <input type="email" placeholder="Insira o Email" name="email" maxlength="150" required /><br />

    <label class="senha" for="psw"><b><span>&#9998;</span>Senha</b></label><br />
    <input type="password" placeholder="Insira a Senha" name="pass" maxlength="18" required /><br />

    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="toggleLogin()">Fechar</button>
  </form>
</div>