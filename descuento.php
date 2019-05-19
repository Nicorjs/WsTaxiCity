<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(
            isset($_POST['usuario']) and
                isset($_POST['total_viaje'])){

                    if($_POST['total_viaje'] > 0)
                      {
                        $saldo_real = 0;
                        $saldo_real = $saldo_real-(($_POST['total_viaje']*10)/100);
                        echo "Saldo total: ".$saldo_real;
                      }
                    else {
                      echo "Saldo insuficiente";
                    }
            }else{
              echo "No hay datos";
            }
                      
}else{
  echo 'Mal metodo';
}

?>                    
