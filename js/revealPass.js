function revealPass() 
{
	const passwordInput = document.getElementById("pass");
	passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}