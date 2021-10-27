function editCartQuantity(productId, previousQuantity)
{
	const input = document.getElementById('quantity' + productId);
	let quantity = parseInt(input.value);

	if (isNaN(quantity) || quantity < 0) quantity = 0;

	if (quantity != previousQuantity) document.location.href = "../php/handlers/cartHandler.php?id=" + productId + "&action=edit&quantity=" + quantity;
}