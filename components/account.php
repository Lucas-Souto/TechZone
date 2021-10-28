<?php
require(dirname(__DIR__) . "/php/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/php/functions/logError.php");

$buttonText = 'Registre-se';
$formTitle = 'Cadastro';
$handlerPath = '../php/handlers/handleSignup.php';
$isMyAccount = false;
$isAdminRegister = false;
$name = '';
$surname = '';
$email = '';
$additional = '';

if (substr($_SERVER['REQUEST_URI'], 0, 20) === "/pages/myAccount.php")
{
  $buttonText = 'Aplicar';
  $formTitle = 'Minha conta';
  $handlerPath = '../php/handlers/handleMyAccount.php';
  $isMyAccount = true;

  if (session_id())
  {
    $user = [];

    try
    {
      $uC = new UsersController();
      $user = $uC->getUserData($_SESSION['userEmail']);
    }
    catch (PDOException $e)
    {
      logError($e, "MyAccount");
      header("Location: ../pages/myAccount.php?internalError=true");
    }

    if (!empty($user))
    {
      $name = $user['name'];
      $surname = $user['surname'];
      $email = $user['email'];
      $additional = $user['additional'];
    }
  }
}
elseif (substr($_SERVER['REQUEST_URI'], 0, 24) === "/pages/registerAdmin.php")
{
  $buttonText = 'Registrar';
  $formTitle = 'Cadastro de usuário';
  $isAdminRegister = true;
}
?>

<div class="card">
  <h5 class="text-center mb-4"><?php echo $formTitle; ?></h5>
  <form id="form" class="form-card" action="<?php echo $handlerPath; ?>" method="POST">
    <?php
    if (isset($_GET['internalError']) && $_GET['internalError'])
    {
      echo "<div style='color: red;'>
        <h2>Ops... Algo deu errado!</h2>
        <p>O que pode ter acontecido:</p>
        <p>1.Já existe uma conta com este e-mail;</p>
        <p>2.Ocorreu um erro no servidor. Tente novamente mais tarde.</p>
      </div>";
    }
    else if (isset($_GET['success']) && $_GET['success'])
    {
      echo "<div style='color: LawnGreen;'>
        <h2>Alterações bem sucedidas!</h2>
      </div>";
    }
    else if (isset($_GET['noChanges']) && $_GET['noChanges'])
    {
      echo "<div style='color: black;'>
        <h2>Não houve alterações.</h2>
      </div>";
    }
    ?>
    <div class="row justify-content-between text-left">
      <div class="form-group col-sm-6 flex-column d-flex"> 
        <label class="form-control-label px-3 required" id="name-label">Nome</label> 
        <input type="text" id="fname" name="fname" value="<?php echo $name; ?>" required /> 
      </div>

      <div class="form-group col-sm-6 flex-column d-flex"> 
        <label class="form-control-label px-3 required" id="lastname-label">Sobrenome</label> 
        <input type="text" id="lname" name="lname" value="<?php echo $surname; ?>" required /> 
      </div>
    </div>
    <div class="row justify-content-between text-left">
      <div class="form-group col-sm-6 flex-column d-flex"> 
        <label class="form-control-label px-3 required">Email</label> 
        <input type="email" id="email" name="email" maxlength="150" value="<?php echo $email; ?>" required /> 
      </div>
      <?php if (!$isMyAccount): ?>
        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3 required" id="cpf-label">CPF</label> 
          <input type="text" id="cpf" name="cpf" onkeypress="CPFMask(this)" maxlength="14"  required /> 
        </div>
      <?php endif; ?>
      <div class="form-group col-sm-6 flex-column d-flex"> 
        <label class="form-control-label px-3 <?php echo $isMyAccount ? '' : 'required' ?>" id="pass-label">Senha</label> 
        <input type="password" id="pass" name="pass" maxlength="18" <?php echo $isMyAccount ? '' : 'required' ?> /> 
        
        <div class="form-check p-0 d-flex align-items-center"> 
          <input class="form-check-input checkbox m-0" type="checkbox" value="" id="flexCheckDefault" onclick="revealPass()" /> 
          <label class="form-check-label px-2 d-flex justify-content-start" for="flexCheckDefault">Revelar senha</label>
        </div>
      </div>
      <?php if ($isAdminRegister): ?>
        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3" id="status-label">Status</label> 
          <select name="status" id="status">
            <option value="user">Usuário</option>
            <option value="collab">Colaborador</option>
            <option value="admin">Administrador</option>
          </select>
        </div>
      <?php endif; ?>
    </div>
      <div class="row justify-content-between text-left">
        <div class="form-group col-12 flex-column d-flex"> 
          <label class="form-control-label px-3">Dados Adicionais</label> 
          <input type="text" id="additional" name="additional" value="<?php echo $additional; ?>" /> 
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="form-group col-sm-6"> 
          <button type="submit" class="d-flex justify-content-center btn-block mx-auto btn-primary align-items-center"><?php echo $buttonText; ?></button> 
        </div>
      </div>
  </form>
</div>