<?php     
    class Dboperations{
        private $con;
        function __construct(){
            require_once dirname(__FILE__).'/DBConnect.php';
            $db = new Dbconnect();
            $this->con = $db->connect();
        }
        function insertar($usuario, $carga_saldo, $numero_tran){
            if($this->existeusuario($usuario))
            {
                if($resultado = $this->con->query("SELECT saldo_real, saldo_contable FROM `carga` WHERE id_conductor = '".$usuario."'"))
                {
                    $row = $resultado->fetch_array(MYSQLI_ASSOC);
                    $saldonuevo = $row["saldo_real"] + $carga_saldo;
                    echo $saldonuevo;
                 }else{
                     echo "Falso";
                 }
            }
            else
            {
                date_default_timezone_set("Chile/Continental");
                $fecha = date("Y-m-d H:i:s");
                $stmt = $this->con->prepare("INSERT INTO `carga` (`id_conductor`, `transaccion`, `saldo_real`, `saldo_contable`, `fecha_carga`) VALUES ('$usuario','$numero_tran',?,?,'$fecha')");
                $stmt->bind_param("dd",$carga_saldo,$carga_saldo);
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
            }
        }
        private function existeusuario($usuario){
            $stmt = $this->con->prepare("SELECT id_conductor FROM `carga` WHERE id_conductor = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute(); 
            $stmt->store_result();
            return $stmt->num_rows > 0;
        }
         
    }



?>