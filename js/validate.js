function validateName(inputName, label) 
{
    const input = document.getElementById(inputName);

    if (input == null) return true;

    const nome = input.value;
    const regex = /([!@#$%¨&*+-=()_'",.<>;:/?{}\[\]\\|ºª^~`´]|\s{2,}|\d)/g;
    const result = nome.search(regex) === -1 && nome.length >= 3;

    return toggleInvalid(document.getElementById(label), result);
}

function validatePass() 
{
    const input = document.getElementById("pass");

    if (input == null) return true;

    const pass = input.value;
    const regex = /(\s)/g;
    const result = pass.length >= 7 && pass.search(regex) === -1;
    console.log(pass.search(regex));
    if (pass.length === 0 && window.location.pathname !== "/pages/register.php") return true;

    return toggleInvalid(document.getElementById("pass-label"), result);
}

function validateCPF() 
{
    const cpfInput = document.getElementById("cpf");

    if (cpfInput == null) return true;

    const cpf = cpfInput.value;
    const regex = /\d{3}.\d{3}.\d{3}-\d{2}/;
    const result = cpf.length === 14 && cpf.search(regex) === 0;

    if (window.location.pathname !== "/pages/register.php" && cpf.length === 0) return true;

    return toggleInvalid(document.getElementById("cpf-label"), result);
}

function toggleInvalid(item, isValid) 
{
    if (isValid) item.classList.remove("invalid");
    else item.classList.add("invalid");

    return isValid;
}

window.onload = function () 
{
    document
        .getElementById("form")
        .addEventListener("submit", function (event) {
            const fN = validateName("fname", "name-label");
            const lN = validateName("lname", "lastname-label");
            const p = validatePass();
            const c = validateCPF();

            if (!(fN && lN && p && c)) event.preventDefault();
        });
};