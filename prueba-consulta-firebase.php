<?php
$url = "https://prueba-b2faa.firebaseio.com/presupuesto.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

//print_r($response);
$data = json_decode($response, true);
foreach($data as $key => $value){
    echo "Concepto: ".$data[$key]["Concepto"]."<br>".
         "ID: ".$data[$key]["ID"]."<br>";
         
}


?>