<?php
require(dirname(__DIR__) . "/php/functions/isSelected.php");
require(dirname(__DIR__) . "/php/functions/autoLoad.php");
require_once(dirname(__DIR__) . "/php/functions/logError.php");

$name = '';
$price = 0;
$quantity = 0;
$category = 'console';
$desc = '';
$isEdit = false;
$idIsSet = false;
$buttonText = 'Registrar';
$handler = '../php/handlers/handleAddProduct.php';
$title = 'Cadastrar produto';
$id = NULL;#isset($_POST['id']) ? $_POST['id'] : $_GET['id'];

if (isset($_POST['id'])) $id = $_POST['id'];
elseif (isset($_GET['id'])) $id = $_GET['id'];

if (substr($_SERVER['REQUEST_URI'], 0, 22) === "/pages/editProduct.php")
{
  $isEdit = true;
  $buttonText = 'Procurar';
  $handler = 'editProduct.php';
  $title = 'Editar produto';

  if (isset($id) && !isset($_GET['notFounded']))
  {
    $product = [];

    try
    {
      $pC = new ProductsController();
      $product = $pC->getProductData($id);
    }
    catch (PDOException $e)
    {
      logError($e, "Edit Product");
      header("Location: ../pages/editProduct.php?internalError=true");
    }

    if (!empty($product))
    {
      $buttonText = 'Aplicar';
      $idIsSet = true;

      $name = $product['name'];
      $price = $product['price'];
      $desc = $product['description'];
      $quantity = $product['quantity'];
      $category = $product['category'];
      $image = $product['image'];
      $handler = "../php/handlers/handleEditProduct.php?id={$id}&originalPath={$image}";
    }
    else header("Location: ../pages/editProduct.php?notFounded=true&id={$id}");
  }
}
?>

<div class="card">
  <h5 class="text-center mb-4"><?php echo $title; ?></h5>
  <form id="productForm" class="form-card" action="<?php echo $handler; ?>" enctype="multipart/form-data" method="POST">
    <?php
    if (isset($_GET['internalError']) && $_GET['internalError']){
      echo "<div style='color: red;'>
        <h2>Ops... Algo deu errado!</h2>
        <p>Ocorreu um erro no servidor. Tente novamente mais tarde.</p>
      </div>";
    }
    else if (isset($_GET['notFounded']) && $_GET['notFounded']){
      echo "<div style='color: red;'>
        <h2>Ops... Algo deu errado!</h2>
        <p>Não encontramos nenhum produto com o id \"{$id}\".</p>
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
    <?php if (!$isEdit || $idIsSet): ?>
      <div class="row justify-content-between text-left">
        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3 required" id="name-label">Nome</label> 
          <input type="text" id="name" name="name" value="<?php echo $name; ?>" required /> 
        </div>

        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3 required" id="price-label">Preço</label> 
          <input type="number" id="price" name="price" min="0.25" step="0.01" value="<?php echo $price; ?>" required /> 
        </div>

        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3 required" id="quantity-label">Quantidade</label> 
          <input type="number" id="quantity" name="quantity" min="0" value="<?php echo $quantity; ?>" required /> 
        </div>

        <div class="form-group col-sm-6 flex-column d-flex"> 
          <label class="form-control-label px-3" id="category-label">Categoria</label> 
          <select name="category" id="category">
              <option value="console" <?php isSelected($category, 'console') ?>>Console</option>
              <option value="computer" <?php isSelected($category, 'computer') ?>>Computador</option>
              <option value="other" <?php isSelected($category, 'other') ?>>Outros</option>
          </select>
        </div>
      </div>
      <div class="row justify-content-between text-left">
        <label class="form-control-label px-3" id="desc-label">Descrição</label> 
        <textarea cols="80" rows="10" id="desc" name="desc"><?php echo $desc; ?></textarea>
      </div>
      <div class="row justify-content-between text-left">
        <label class="form-control-label px-3 <?php echo $isEdit ? '' : 'required' ?>" id="file-label">Imagem</label> 
        <input type="file" id="file" name="file" accept="image/png, image/jpeg, image/jpg" <?php echo $isEdit ? '' : 'required' ?> />
        <?php if($isEdit && $idIsSet): ?>
          <label class="form-control-label px-3" id="status-label">Ação</label> 
          <select name="action" id="action">
            <option value="edit">Editar</option>
            <option value="delete">Excluir</option>
          </select>
        <?php endif; ?>
      </div>
    <?php elseif($isEdit && !$idIsSet): ?>
      <div class="row justify-content-between text-center">
        <label class="form-control-label px-3 required" id="name-label">Id do produto</label> 
        <input type="number" id="id" name="id" required /> 
      </div>
    <?php endif;?>
    <div class="row justify-content-center">
      <div class="form-group col-sm-6"> 
        <button type="submit" class="d-flex justify-content-center btn-block mx-auto btn-primary align-items-center"><?php echo $buttonText; ?></button> 
      </div>
    </div>
  </form>
</div>