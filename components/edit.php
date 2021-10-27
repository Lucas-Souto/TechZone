<div class="card">
  <h5 class="text-center mb-4">Editar usuário</h5>
  <form id="form" class="form-card" action="../php/handlers/handleUpdate.php" method="POST">
    <?php
    if (isset($_GET['internalError']) && $_GET['internalError'])
    {
      echo "<div style='color: red;'>
        <h2>Ops... Algo deu errado!</h2>
        <p>Ocorreu um erro no servidor. Tente novamente mais tarde.</p>
      </div>";
    }
    else if (isset($_GET['success']) && $_GET['success']){
      echo "<div style='color: LawnGreen;'>
        <h2>Alterações bem sucedidas!</h2>
      </div>";
    }
    else if (isset($_GET['noChanges']) && $_GET['noChanges']){
      echo "<div style='color: black;'>
        <h2>Não houve alterações.</h2>
      </div>";
    }
    ?>
    <div class="row justify-content-between text-left">
      <label class="form-control-label px-3 required">Email</label> 
      <input type="email" id="email" name="email" maxlength="150" required />

      <label class="form-control-label px-3">Novo Email</label> 
      <input type="email" id="new-email" name="new-email" maxlength="150" />  
    </div>
    <div class="row justify-content-between text-left">
      <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3" id="cpf-label">CPF</label> 
          <input type="text" id="cpf" name="cpf" onkeypress="CPFMask(this)" maxlength="14" /> 
      </div>
      <div class="form-group col-sm-6 flex-column d-flex"> 
        <label class="form-control-label px-3" id="pass-label">Senha</label> 
        <input type="password" id="pass" name="pass" maxlength="18" /> 
        
        <div class="form-check p-0 d-flex align-items-center"> 
          <input class="form-check-input checkbox m-0" type="checkbox" value="" id="flexCheckDefault" onclick="revealPass()" /> 
          <label class="form-check-label px-2 d-flex justify-content-start" for="flexCheckDefault">Revelar senha</label>
        </div>
      </div>
      <div class="row justify-content-between text-left"> 
        <label class="form-control-label px-3" id="status-label">Status</label> 
        <select name="status" id="status">
          <option value="user">Usuário</option>
          <option value="collab">Colaborador</option>
          <option value="admin">Administrador</option>
        </select>
        <label class="form-control-label px-3" id="status-label">Ação</label> 
        <select name="action" id="action">
          <option value="edit">Editar</option>
          <option value="delete">Excluir</option>
        </select>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="form-group col-sm-6"> 
        <button type="submit" class="d-flex justify-content-center btn-block mx-auto btn-primary align-items-center">Aplicar</button> 
      </div>
    </div>
  </form>
</div>