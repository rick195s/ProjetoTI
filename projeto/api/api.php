<?php
header('Content-Type: text/html; charset=utf-8');



if ($_SERVER["REQUEST_METHOD"] == "POST"){

}else if($_SERVER["REQUEST_METHOD"] == "GET"){

	$valor = file_get_contents("files/sensores/temperatura/sensor.txt");

	$sensor_temperatura = file_get_contents("files/sensores/temperatura/sensor.txt");

	$logm1 = file_get_contents("files/sensores/movimento1/log.txt");
	$nome_movimento1 = file_get_contents("files/sensores/movimento1/nome.txt");


	$logm2 = file_get_contents("files/sensores/movimento2/log.txt");
	$nome_movimento2 = file_get_contents("files/sensores/movimento2/nome.txt");


	$logm3 = file_get_contents("files/sensores/movimento3/log.txt");
	$nome_movimento3 = file_get_contents("files/sensores/movimento3/nome.txt");


	$logm4 = file_get_contents("files/sensores/movimento4/log.txt");
	$nome_movimento4 = file_get_contents("files/sensores/movimento4/nome.txt");

	$tipo_computador1 = file_get_contents("files/Computadores/computador1/nome.txt");
	$valor_hora_comp1 = file_get_contents("files/Computadores/computador1/log.txt");
	$ip_computador1 = file_get_contents("files/Computadores/computador1/ip.txt");

	$tipo_computador2 = file_get_contents("files/Computadores/computador2/nome.txt");
	$valor_hora_comp2 = file_get_contents("files/Computadores/computador2/log.txt");
	$ip_computador2 = file_get_contents("files/Computadores/computador2/ip.txt");

	$nome_luz1 = file_get_contents("files/Luzes/grupo1/nome.txt");
	$logl1 = file_get_contents("files/Luzes/grupo1/log.txt");

	$nome_luz2 = file_get_contents("files/Luzes/grupo2/nome.txt");
	$logl2 = file_get_contents("files/Luzes/grupo2/log.txt");

	$nomeal = file_get_contents("files/Edifício/Alarme/nome.txt");
	$logal = file_get_contents("files/Edifício/Alarme/log.txt");

	$nomefan1 = file_get_contents("files/Edifício/Fan1/nome.txt");
	$logfan1 = file_get_contents("files/Edifício/Fan1/log.txt");

	$nomefan2 = file_get_contents("files/Edifício/Fan2/nome.txt");
	$logfan2 = file_get_contents("files/Edifício/Fan2/log.txt");

	$nomejan1 = file_get_contents("files/Edifício/Janela1/nome.txt");
	$logjan1 = file_get_contents("files/Edifício/Janela1/log.txt");

	$nomejan2 = file_get_contents("files/Edifício/Janela2/nome.txt");
	$logjan2 = file_get_contents("files/Edifício/Janela2/log.txt");

	$nomeporta1 = file_get_contents("files/Edifício/PortaPrincipal/nome.txt");
	$logporta1 = file_get_contents("files/Edifício/PortaPrincipal/log.txt");

	$nomeporta2 = file_get_contents("files/Edifício/PortaSecundária/nome.txt");
	$logporta2 = file_get_contents("files/Edifício/PortaSecundária/log.txt");

	$nometermo = file_get_contents("files/Edifício/Termostato/nome.txt");
	$logtermo = file_get_contents("files/Edifício/Termostato/log.txt");



	$valor =  explode(";",$valor);
	$logm1 = explode(";", $logm1);
	$logm2 = explode(";", $logm2);
	$logm3 = explode(";", $logm3);
	$logm4 = explode(";", $logm4);
	$logl1 = explode(";", $logl1);
	$logl2 = explode(";", $logl2);
	$logal = explode(";", $logal);
	$logfan1 = explode(";", $logfan1);
	$logfan2 = explode(";", $logfan2);
	$logporta1 = explode(";", $logporta1);
	$logporta2 = explode(";", $logporta2);
	$logtermo = explode(";", $logtermo);
	$logjan1 = explode(";", $logjan1);
	$logjan2 = explode(";", $logjan2);


	for($i = 0; $i<=10; $i++){
		if($logal[1]=='ativo'){
			$coral= 'class="badge badge-pill badge-success"';
		}
		else{
			$coral= 'class="badge badge-pill badge-danger"';
		}

		if($logporta1[1]=='aberta'){
			$corporta1= 'class="badge badge-pill badge-success"';
		}
		else{
			$corporta1= 'class="badge badge-pill badge-danger"';
		}

		if($logporta2[1]=='aberta'){
			$corporta2= 'class="badge badge-pill badge-success"';
		}
		else{
			$corporta2= 'class="badge badge-pill badge-danger"';
		}

		if($logfan1[1]=='ativo'){
			$corfan1= 'class="badge badge-pill badge-success"';
		}
		else{
			$corfan1= 'class="badge badge-pill badge-danger"';
		}

		if($logfan2[1]=='ativo'){
			$corfan2= 'class="badge badge-pill badge-success"';
		}
		else{
			$corfan2= 'class="badge badge-pill badge-danger"';
		}

		if($logjan1[1]=='aberta'){
			$corjan1= 'class="badge badge-pill badge-success"';
		}
		else{
			$corjan1= 'class="badge badge-pill badge-danger"';
		}

		if($logjan2[1]=='ativo'){
			$corjan2= 'class="badge badge-pill badge-success"';
		}
		else{
			$corjan2= 'class="badge badge-pill badge-danger"';
		}

		if($logtermo[1]=='ativo'){
			$cortermo= 'class="badge badge-pill badge-success"';
		}
		else{
			$cortermo= 'class="badge badge-pill badge-danger"';
		}
	}
}