<?php
class  MVCEstancia {
    protected $db;
    protected $conn;
    private $sql;
    private $id;
    private $nombreEstancia;
 
    public function setNombreEstancia( $nombreEstancia){
        $this->nombreEstancia = $nombreEstancia;

    }

    public function getNombreEstancia( ){
       return $this->nombreEstancia;

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
        $this->sql="CALL sp_estancia_create('$this->nombreEstancia')"; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_estancia_update('$this->nombreEstancia', '$this->id')"; 
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
        $this->sql="CALL sp_estancia_delete('$this->id')"; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_estancia_read()";  
        $select = $this->conn->query($this->sql);
        $colecciones = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>   utf8_encode($row['Int_IdEstancia_Inst']),
               'nombreEstancia'  =>   utf8_encode($row['VchNombreEstancia'])
            );
        }
         $encabezado=array("estancia"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_estancia_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
       $this->closeConnection();
        return $total[0];
    }
}