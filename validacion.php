<?php
  $saldo_real=$_POST['saldo_real'];
  $fecha_carga=$_POST['fecha_carga'];
  $saldo_contable=$_POST['saldo_contable'];
  $valor_viaje=$_POST['valor_viaje'];
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['usuario']) and isset($_POST['saldo_real'])and isset($_POST['fecha_carga']) and isset($_POST['valor_viaje']) and isset($_POST['saldo_contable']))
            {
              if($saldo_real>=$valor_viaje or $saldo_contable>=$valor_viaje)
              {
                  date_default_timezone_set("Chile/Continental");
                  $fecha1 = new DateTime();
                  $fecha1->format('Y-m-d H:i:s');
                  $fecha2 = new DateTime("$fecha_carga");
                  $fecha2->format('Y-m-d H:i:s');

                  if(($fecha2->format('Y-m-d H:i:s'))<($fecha1->format('Y-m-d H:i:s')))
                  {
                      $interval = date_diff($fecha2, $fecha1);

                      $diferencia_dias=$interval->format('%d');
                      if($diferencia_dias<=0)
                      {
                          echo "entra a saldo real";
                          if($saldo_real>=$valor_viaje)
                          {
                            echo "Se puede realizar Viaje con saldo Real";
                          }
                          else {
                            echo "No tienes saldo suficiente para realizar el viaje";
                          }
                      }
                      else
                      {
                        echo "entra a saldo contable";
                        if($saldo_contable>=$valor_viaje)
                        {
                          echo "Se puede realizar viaje con saldo Contable";
                        }
                        else {
                          echo "No tienes saldo suficiente para realizar el viaje";
                        }
                      }

                    }

                  else {
                    echo "Error fecha de carga mayor, INCORRECTO";
                    }

            }
            else{
              echo "Saldo insuficiente";
            }
    }
  }
?>
