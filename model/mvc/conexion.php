<?php
class Conexion{
    private $connection;
    private $host = 'localhost';
    private $database = "dbtoolcreation";
    private $userName = "root";
    private $pwd = "admin1";


    //contructor  que crear la conexion
    public  function __construct(){
        $this->connection = mysqli_connect($this->host, $this->userName, $this->pwd, $this->database);
        
    }

    //metodo que  cierra la conexion
    public function closeConnection( $cnn ) {
        mysqli_close($cnn);
     }

    //Obterner conexion
    public function getConnection(){
        return $this->connection;
    }
}

// $cnn = new Conexion();

// if($cnn->getConnection()){
//     echo 'conexion exitosa';
// }else{
//     echo 'conexion fallida';
//     var_dump($cnn->getConnection());
// }