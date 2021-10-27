<?php
function createCard($imagePath, $name, $price, $id = -1)
{
	$add = $id === -1 ? '' : "id='product{$id}'";
	$path = "pages/viewProduct.php?id={$id}";

	echo 
	"<div class='card-shop' {$add}>
		<a class='card-link' href='{$path}'></a>
		<img
		class='card-shop-img'
		src='{$imagePath}''
		alt='{$name}'
		/>
		<div class='card-text-area'>
			<a class='card-link' href='{$path}'></a>
			<h2>{$name}</h2>
			<p>{$price}</p>
		</div>
	</div>";
}

function createShoppingCard($imagePath, $name, $price, $quantity, $inStock, $id = -1)
{
	$add = $id === -1 ? '' : "id='product{$id}'";
	$path = "viewProduct.php?id={$id}";
	$class = $quantity > $inStock ? 'class="invalid"' : '';

	echo 
	"<div class='card-shop' {$add}>
		<img
		class='card-shop-img'
		src='{$imagePath}''
		alt='{$name}'
		/>
		<div class='card-text-area'>
			<a class='card-link' href='{$path}'></a>
			<h2>{$name}</h2>
			<p>{$price}</p>
		</div>
		<hr />
		<div class='cart-data'>
			<div class='card-input'>
				<label for='quantity'>Quantidade:</label>
				<input {$class} type='number' value='{$quantity}' id='quantity{$id}' onblur='editCartQuantity({$id}, {$quantity})' />
			</div>
			<a class='remove-button' href='../php/handlers/cartHandler.php?id={$id}&action=delete'>Remover</a>
		</div>
	</div>";
}
?>