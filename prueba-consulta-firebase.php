<?php
$url = "https://prueba-b2faa.firebaseio.com/usuario.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
print_r($response);
$data = json_decode($response, true);
$resultado = array_filter($data);
foreach($data as $key => $value){
    echo "<br>".$key."<br>".
         "Id: ".$data[$key]["Id"]."<br>".
         "Monto: ".$data[$key]["Monto"]."<br>".
         "N_tran: ".$data[$key]["N_tran"]."<br>";        
}
//date_default_timezone_set("Chile/continental");
//$fecha = date("d-m-Y H:i:s");
//echo $fecha;

?>