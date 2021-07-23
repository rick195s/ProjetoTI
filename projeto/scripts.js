// São criadas variáveis para guardar os elementos identificado por id

const rmCheck = document.getElementById("rememberMe");
const username = document.getElementById("username");

/* Ao carregar a página caso a checkbox tenha sido selecionada anteriormente 
e o seu valor seja diferente de vazio o campo username irá ficar com o seu valor
armazenado e a checkbox fica selecionada */

if (localStorage.checkbox && localStorage.checkbox != "") {
    rmCheck.setAttribute("checked", "checked");
    username.value = localStorage.username;
}

/* Quando o utilizador clica no botão do formulário de login esta função 
é chamada no qual altera os valores dos inputs do formulário */

function lsRememberMe() {
    /* Caso a checkbox "Remember me" esteja selecionada e o valor do campo username seja 
	diferente de vazio o valor do campo username irá ficar armazenado e o estado da checkbox
	também.
	
	Senão os valores armazenados do username e da checkbox ficarão vazios*/

    if (rmCheck.checked && username.value != "") {
        localStorage.username = username.value;
        localStorage.checkbox = rmCheck.value;
    } else {
        localStorage.username = "";
        localStorage.checkbox = "";
    }
}
