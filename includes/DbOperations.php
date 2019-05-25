<?php     
    class Dboperations
{
        private $con;
        private $FIREBASE = "___URL___FIREBASE____";
        function __construct(){
            //llamo al archivo, para poder crear la clase de conexión a la base de datos
            require_once dirname(__FILE__).'/DBConnect.php';
            //creando el objeto
            $db = new Dbconnect();
            $this->con = $db->connect();
        }
        //********Funciones publicas de la clase************* */
        //inserta o midifica usuario en db y firebase ?
        function insertar($usuario, $carga_saldo, $numero_tran)
        {
            if($this->existeusuario($usuario))
            {
                //cambiar esto por una funcion update !!!
                if($this->update($usuario,$carga_saldo,$numero_tran))
                {
                    return false;
                }
            }
            else
            {
                return $this->agregar($usuario,$carga_saldo,$numero_tran);
            }
        }
        //funcion decuento
        function descuento($usuario,$descuento,$valor_viaje)
        {
            if($resultado = $this->con->query("SELECT saldo_real FROM `carga` WHERE id_conductor = '".$usuario."'"))
            {
                $row = $resultado->fetch_array(MYSQLI_ASSOC);
                $saldonuevo = $row["saldo_real"] - $descuento;
                if ($this->existeusuario2($usuario))
                {
                    if($stmt = $this->con->query("UPDATE `carga` SET saldo_real = '".$saldonuevo."' WHERE id_conductor = '".$usuario."'") and $stmt = $this->con->query("UPDATE `descuento` SET saldo_real = '".$saldonuevo."' , valor_viaje = '".$valor_viaje."' WHERE id_conductor = '".$usuario."'") and $this->descuentofirebase($usuario, $saldonuevo , $valor_viaje))
                    {
                        $this->con->close();
                        return true;
                        
                    }
                    else
                    {
                        $this->con->close();
                        return false;
                        
                    }
                }
                else{
                    if($stmt = $this->con->query("UPDATE `carga` SET saldo_real = '".$saldonuevo."' WHERE id_conductor = '".$usuario."'") and $stmt = $this->con->query("INSERT INTO `descuento` (`id_conductor`, `saldo_real`, `valor_viaje`) VALUES ('".$usuario."', '".$saldonuevo."', '".$valor_viaje."')") and $this->descuentofirebase($usuario, $saldonuevo , $valor_viaje) )
                    {
                        $this->con->close();
                        return true;
                        
                    }
                    else
                    {
                        $this->con->close();
                        return false;
                        
                    }
                }   
            }
            else
            {
                return false;
            }
        }
        
        //****************Funciones privadas de la clase *************************** */
        //Funcion update en bases de datos
        private function update($usuario, $carga_saldo, $numero_tran)
        {
            $resultado = $this->con->query("SELECT saldo_real, saldo_contable FROM `carga` WHERE id_conductor = '".$usuario."'");
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            $saldonuevo = $row["saldo_real"] + $carga_saldo;
            date_default_timezone_set("Chile/Continental");
            $fecha = date("Y-m-d H:i:s");
            if($stmt = $this->con->query("UPDATE `carga` SET saldo_real = '".$saldonuevo."', saldo_contable = '".$carga_saldo."', fecha_carga = '".$fecha."', transaccion = '".$numero_tran."' WHERE id_conductor = '".$usuario."'") and $this->updatefirebase($usuario, $saldonuevo , $numero_tran, $carga_saldo, $fecha)){
                $this->con->close();
                return true;
                
            }
            else{
             return false;
             echo "Un error a ocurrido.";
         }
        }
        //funcion agrega datos a bases de datos , si usuario mo existe
        private function agregar($usuario, $carga_saldo, $numero_tran)
        {
            //agregar otro funcion para firebase
            date_default_timezone_set("Chile/Continental");
            $fecha = date("Y-m-d H:i:s");
            $stmt = $this->con->prepare("INSERT INTO `carga` (`id_conductor`, `transaccion`, `saldo_real`, `saldo_contable`, `fecha_carga`) VALUES ('$usuario','$numero_tran',?,?,'$fecha')");
            $stmt->bind_param("dd",$carga_saldo,$carga_saldo);
            if($stmt->execute() and $this->agregarfirebase($usuario, $carga_saldo, $numero_tran,$fecha)){
                $this->con->close();
                return true;
                
            }else{
                $this->con->close();
                return false;
            }



        }
        //comprueba la existencia de un usuario.
        private function existeusuario($usuario)
        {
            $stmt = $this->con->prepare("SELECT id_conductor FROM `carga` WHERE id_conductor = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute(); 
            $stmt->store_result();

            return $stmt->num_rows > 0;
        }
        //comprueba la existencia de un usuario en la tabla decuento
        private function existeusuario2($usuario)
        {
            $stmt = $this->con->prepare("SELECT id_conductor FROM `descuento` WHERE id_conductor = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute(); 
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
        //Funciones para agregar o moodificar datos en firebase
        private function agregarfirebase($usuario, $carga_saldo,$numero_tran,$fecha)
        {
            $NODE_PUT = "$usuario.json";
            $data = array(
                "Saldo_real" => $carga_saldo,
                "Saldo_contable" => $carga_saldo,
                "transaccion" => $numero_tran,
                "Fecha_recarga" => $fecha,
                "valor_ultimo_viaje" => "",
            );
            // JSON encoded
            $json = json_encode($data);
            // Initialize cURL
            $curl = curl_init();
            curl_setopt( $curl, CURLOPT_URL, $this->FIREBASE . $NODE_PUT );
            curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PUT" );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $json);
            if(curl_exec( $curl )){
                curl_close( $curl );
                return true;
            }else{
                return false;
            }

        }
       private function updatefirebase($usuario, $saldo_real , $numero_tran, $saldo_contable, $fecha)
        {
            $NODE_PATCH = "$usuario.json";
            $data = array(
                "transaccion" => $numero_tran,
                "Saldo_real" => $saldo_real,
                "Saldo_contable" => $saldo_contable,
                "Fecha_recarga" => $fecha,
                "valor_ultimo_viaje" => "",
            );
            // JSON encoded
            $json = json_encode($data);
            // Initialize cURL
            $curl = curl_init();
            curl_setopt( $curl, CURLOPT_URL, $this->FIREBASE . $NODE_PATCH );
            curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );
            if(curl_exec($curl)){
                curl_close($curl);
                return true;
            }else{
                return false;
            }
        }
        private function descuentofirebase($usuario,$saldo_real,$valor_viaje)
        {
            $NODE_PATCH = "$usuario.json";
            $data = array(
                "Saldo_real" => $saldo_real,
                "valor_ultimo_viaje" => $valor_viaje,
            );
            // JSON encoded
            $json = json_encode($data);
            // Initialize cURL
            $curl = curl_init();
            curl_setopt( $curl, CURLOPT_URL, $this->FIREBASE . $NODE_PATCH );
            curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );
            if(curl_exec($curl)){
                curl_close($curl);
                return true;
            }else{
                return false;
            }
        }

}



?>