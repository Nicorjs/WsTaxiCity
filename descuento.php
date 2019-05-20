<?php
require_once 'includes/DbOperations.php';
$response = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['usuario']) and isset($_POST['total_viaje'])){

                    if($_POST['total_viaje'] > 0)
                      {
                        $usuario = $_POST['usuario'];
                        $valor_viaje = $_POST['total_viaje'];
                        $porcentaje_resta = 0.10;
                        $total_descuento = ($valor_viaje * 10) / 100;
                        $db = new DbOperations();//creacion de la conexion a las bases de datos
                            if($db->descuento($usuario,$total_descuento,$valor_viaje)){
                              $response ["error"]= false; 
                              $response ["message"] = "Descuento realizado con exito";
                            }
                      }
                    else {
                      $response ["error"]= true; 
                      $response ["message"] = "Descuento realizado con exito";
                    }
            }else{
              $response ["error"]= true; 
              $response ["message"] = "Descuento realizado con exito";
            }
                      
}else{
  $response ["error"]= true; 
  $response ["message"] = "Descuento realizado con exito";
}
echo json_encode($response); 
?>                    
