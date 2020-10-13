
<?php
require ('conexion.php');
class  MVCEstadoUsuario {
    protected $db;
    protected $conn;
    private $sql;
    private $id;
    private $nombreEstado;
    private $descripcion;
 
    public function setNombreEstado( $nombreEstado){
        $this->nombreEstado = $nombreEstado;

    }

    public function getNombreEstado( ){
       return $this->nombreEstado;

    }

    public function setId( $id ){
        $this->id = $id;
    }

    public function getId(){
      return $this->id;
    }

    public function getDescripcion(){
      return $this->descripcion;
    }

    public function setDescripcion($descripcion){
         $this->descripcion = $descripcion;
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
        $this->sql="CALL sp_estadousuario_create('$this->nombreEstado', '$this->descripcion')"; 
        $insert = $this->conn->query( $this->sql);
       $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_estadousuario_update('$this->nombreEstado', '$this->descripcion' , '$this->id')"; 
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
        $this->sql="CALL sp_estadousuario_delete('$this->id');"; 
        $delete = $this->conn->query($this->sql);
       $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_estadousuario_read();";  
        $select = $this->conn->query($this->sql);
        $colecciones = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>  $row['Int_Estado_U'],
               'nombreEstado'  =>  $row['Vch_Nombre_Estado_U'],
               'descripcion'  =>  $row['Vch_Descripcion']

            );
        }
         $encabezado=array("stateUser"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "SELECT COUNT(*) FROM TblEstadoUsuario";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
       $this->closeConnection();
        return $total[0];
    }
}