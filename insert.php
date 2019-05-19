<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    $usuario = $_POST['usuario'];
    $numero_tran = $_POST['numero_tran'];
    $saldo_cargado = $_POST['carga_saldo'];
    $url = "https://prueba-b2faa.firebaseio.com/usuario.json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_POST, 1);
    $data= '"' . $usuario . '":{"Id": "123" ,"Monto": "' . $saldo_cargado . '","N_tran": "' . $numero_tran . '" }';
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    //contable es el que se carga
    //saldo real donde van los decuentos.
    $response = curl_exec($ch);
    if(curl_errno($ch)){
        echo 'Error: '.curl_errno($ch);
    }else{
        echo "listo";
    }
}
?>