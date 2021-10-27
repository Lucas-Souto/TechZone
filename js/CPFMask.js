function CPFMask(input) 
{
	setTimeout(() => applyMask(input), 1);
}

function applyMask(input) 
{
	input.value = input.value
		.replace(/\D/g, "")
		.replace(/(\d{3})(\d)/, "$1.$2")
		.replace(/(\d{3})(\d)/, "$1.$2")
		.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
		.substring(0, 14);
}