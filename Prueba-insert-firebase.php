<?php   
$data= '{"Concepto":"curso de php","Subtotal":"200","ID":"1"}';
$url = "https://prueba-b2faa.firebaseio.com/presupuesto.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

$response = curl_exec($ch);
if(curl_errno($ch)){
    echo 'Error: '.curl_errno($ch);
}else{
    echo "listo";
}
?>