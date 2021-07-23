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

function updateDisp(name, type, value, state){
    /*
    Atualizar os dados dos dispositivos através da api sem ser necessário
    alterar a página do utilizador
     */

    data={
      name:name,
      type: type,
      value: value,
      state: state
    };

    $.post( "api/updateDisp", data, function (data, status){
        alert(status);
    });

}

// Função que irá decidir qual chart é que irá ser renderizado para
// cada tipo de dispositivo

function renderChart(name,type){

    $.get('api/findHist?type='+type+'&name='+name, function (data, status) {

        switch (type){
            case "sensor":
                lineChart(data, name);
                break;

            case "atuador":

                break;
            default:
                break;
        }


    });

}

// Irá apresentar um gráfico de linhas para alguns tipos de dispositivos

function lineChart(data, name){

    var data = JSON.parse(data);
    var data = data.slice(data.length-40, data.length);
    var values = new Array(data.length);
    var dates = new Array(data.length);



    for (var i = 0; i < data.length; i++) {
        dates[i] = data[i]["date"];

        switch (data[i]["value"]){

            case "Fogo Detetado":
            case "Movimento Detetado":
                values[i] = 2;
                break;

            case "Sem Fogo":
            case "Sem Movimento":
                values[i] = 0;
                break;
            default:
                values[i] = parseFloat(data[i]["value"]);
                break;


        }

        isNaN(values[i]) ? values[i] = 0 : 0;


    }
    chart("line", values, dates, name);

}



// Função que irá renderizar o gráfico no canvas com o id "historyChart"
function chart(chartType, yValues, xValues , label ){

    var ctx = document.getElementById('historyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: xValues,
            datasets: [{
                label: label,
                data: yValues,
                borderColor: [
                    'rgb(34,36,49)',
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}