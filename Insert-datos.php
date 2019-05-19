<?php
require_once 'includes/DbOperations.php';
    $response = array();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        if( isset($_POST['usuario']) and isset($_POST['carga_saldo']) and isset($_POST['numero_tran'])){
                            $db = new DbOperations();
                            if($db->insertar($_POST['usuario'],$_POST['carga_saldo'],$_POST['numero_tran'])
                                ){
                                $response['error'] = false;
                                $response['message'] = "Datos insertados";
                            }else{
                                $response['error'] = true;
                                $response['message'] = "Usuario ya exisite";
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