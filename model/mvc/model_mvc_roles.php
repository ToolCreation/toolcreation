<?php
require ('conexion.php');
class  MVCRoles  {
    protected $db;
    protected $conn;
    protected $params;
    private $id;
    private $nombreRol;
    
    private $sql;
 
    public function setNombreRol( $nombreRol){
        $this->nombreRol = $nombreRol;

    }

    public function getNombreRol( ){
       return $this->nombreRol;

    }

    public function setId( $id ){
        $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }
    
    public function __construct(){
        $this->startDB();
    }

    public function startDB(){
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection(); 
    }

    public function closeConnection(){
        $this->db->closeConnection( $this->conn );
     }  

    public function insertData(){
        $this->sql="CALL sp_rol_create('$this->nombreRol')"; 
        $insert = $this->conn->query($this->sql);
       $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_rol_update('$this->nombreRol', '$this->id')"; 
        $update = $this->conn->query($this->sql);
        if($update){
            $encabezado=array("msj"=>"success");
        }else{
            $encabezado=array("msj"=>$update);
        }
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnection();
        return $json_string;
    }
    
    public function deleteData(){
        $this->sql="CALL sp_rol_delete('$this->id') "; 
        $delete = $this->conn->query( $this->sql);
       $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_rol_read()";  
        $select = $this->conn->query($this->sql);
        $rol = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $rol[] = array(
               'id' =>  utf8_encode( $row['IdIntRol']),
               'nombreRol'  =>   utf8_encode($row['vchNombre'])
            );
        }
         $encabezado=array("rol"=>$rol);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_rol_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}