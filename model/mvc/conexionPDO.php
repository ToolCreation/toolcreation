<?php
class ConexionPDO{
    private $conexion;

    public function __construct()
    {
        try {
 
            $this->conexion = new PDO('mysql:host=localhost;dbname=dbtoolcreation', 'root', 'admin1');
            $this->conexion->exec("SET CHARACTER SET utf8");
 
        } catch (PDOException $e) {
 
            print "Error!: " . $e->getMessage();
 
            die();
        }
    }

    public function Obtener_conexion(){
        return $this->conexion;
    }
    
    public function prepare($sql)
    {
        return $this->conexion->prepare($sql);
 
    }
}


