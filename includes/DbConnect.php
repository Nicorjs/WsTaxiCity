<?php     
    class Dbconnect{
        private $con;
        function __contruct(){

        }
        function connect(){
            include_once dirname (__FILE__).'/Constants.php';
            $this->con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            if(mysqli_connect_errno()){
                echo "Error".mysqli_coneect_err();

            }
            return $this->con;

        }


    }



?>