
<?php
require ('conexion.php');
class  MVCEstadoTema {
    protected $db;
    protected $conn;
    private $sql;
    private $id;
    private $nombreEstadoTema;
 
    public function setNombreEstado( $nombreEstadoTema){
        $this->nombreEstadoTema = $nombreEstadoTema;

    }

    public function getNombreEstado( ){
       return $this->nombreEstadoTema;

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
        $this->sql="CALL sp_estadotema_create(' $this->nombreEstadoTema ')"; 
        $insert = $this->conn->query($this->sql);
       $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_estadotema_update('$this->nombreEstadoTema' , '$this->id')"; 
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
        $this->sql="CALL sp_estadotema_delete('$this->id') "; 
        $delete =  $this->conn->query( $this->sql);
       $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL  sp_estadotema_read()";  
        $select =  $this->conn->query($this->sql);
        $colecciones = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>  $row['Int_IdEstado_T'],
               'nombreEstadoTema'  =>  $row['Vch_NombreEstado_T']
            );
        }
         $encabezado=array("stateTema"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "SELECT COUNT(*) FROM TblEstado_Tema";
        $count =  $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}