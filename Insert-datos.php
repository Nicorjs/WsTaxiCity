<?php
require_once 'includes/DbOperations.php';
    $response = array();
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    { 
        if( isset($_POST['usuario']) and isset($_POST['carga_saldo']) and isset($_POST['numero_tran'])){
                            $db = new DbOperations();//creacion de la conexion a la base de datos
                            if($db->insertar($_POST['usuario'],$_POST['carga_saldo'],$_POST['numero_tran']))
                            {
                                $response['error'] = false;
                                $response['message'] = "Datos Enviados correctamente";
                            }
                            else
                            {
                                $response['error'] = false;
                                $response['message'] = "Nueva carga ingresada exitosamante, espera tu confirmaci&oacute;n.";
                            }
                            
                        }else{
                            $response['error'] = true;
                            $response['message'] = "Faltan Datos";
                        
                        }
    }else{
        $response['error'] = true;
        $response['message'] = "Invalid Request";

    }   
echo json_encode($response); 
?>