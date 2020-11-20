<?php
require('conexion.php');
class MVCTipoPromocion{
    protected $db;
    protected $conn;
    private $sql;
    private $nombreTipoPromocion;
    private $id;
 
    public function __construct(){
        $this->startDB();
    }

    public function setNombreTipoPromocion( $value){  $this->nombreTipoPromocion = $value;  }
    public function getNombreTipoPromocion(){ return $this->nombreTipoPromocion; }
    public function setId( $id ){ $this->id = $id; }
    public function getId(){ return $this->id; }

    public function startDB(){
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection(); 
    }

    public function closeConnection(){
       $this->db->closeConnection( $this->conn );
    }
    public function insertData(){
        $this->sql="CALL sp_tipopromo_create('$this->nombreTipoPromocion')"; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_tipopromo_update('$this->nombreTipoPromocion', '$this->id')"; 
        $update = $this->conn->query($this->sql);
        $this->closeConnection();
        if($update){
            $encabezado=array("msj"=>"success");
        }else{
            $encabezado=array("msj"=>$update);
        }
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        return $json_string;
    }
    
    public function deleteData(){
        $this->sql="CALL sp_tipopromo_delete('$this->id') "; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_tipopromo_read()";  
        $select = $this->conn->query($this->sql);
        $rol = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $rol[] = array(
               'id' =>   utf8_encode($row['Int_Id_Tipo_Prom']),
               'nombreTipoPromo'  =>   utf8_encode($row['Vch_NombreTipo_Pro'])
            );
        }
         $encabezado=array("tipo"=>$rol);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

         $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_tipopromo_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}