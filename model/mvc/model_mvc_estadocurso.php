<?php
require('conexion.php');
class MVCEstadoCurso{
    protected $conn;
    private $sql;
    private $id;
    private $nombreEstadoCurso;
 
    public function setNombreEstadoCurso( $nombreEstadoCurso){
        $this->nombreEstadoCurso = $nombreEstadoCurso;

    }

    public function getNombreEstadoCurso( ){
       return $this->nombreEstadoCurso;

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
        $this->sql="CALL sp_estadocurso_create('$this->nombreEstadoCurso')"; 
        $insert = $this->conn->query( $this->sql);
       $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_estadocurso_update('$this->nombreEstadoCurso', '$this->id'); "; 
        $update =  $this->conn->query($this->sql);

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
        $this->sql="CALL sp_estadocurso_delete('$this->id')"; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_estadocurso_read()";  
        $select = $this->conn->query( $this->sql);
        $colecciones = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>  $row['Int_IdEstado_C'],
               'nombreEstadoCurso'  =>  $row['Vch_NombreEstado_c']
            );
        }
         $encabezado=array("estadoCurso"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "SELECT count(*) FROM TblEstado_Curso";
        $count = $this->conn->query( $this->sql);
        $total = mysqli_fetch_array($count);
       $this->closeConnection();
        return $total[0];
    }
}