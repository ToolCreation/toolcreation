<?php
class  MVCGradoConocimiento  {
    protected $db;
    protected $conn;
    private $sql;
    private $id;
    private $nombreGradoConocimiento;
 
    public function setNombreGradoConocimiento( $nombreGradoConocimiento){
        $this->nombreGradoConocimiento = $nombreGradoConocimiento;

    }

    public function getNombreGradoConocimiento( ){
       return $this->nombreGradoConocimiento;

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
        $this->sql="CALL sp_grado_conocimiento_create('$this->nombreGradoConocimiento');"; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_grado_conocimiento_update('$this->nombreGradoConocimiento', '$this->id')"; 
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
        $this->sql="CALL sp_grado_conocimiento_delete('$this->id') "; 
        $delete = $this->conn->query($this->sql);
       $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_grado_conocimiento_read()";  
        $select = $this->conn->query($this->sql);
        $colecciones = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>   utf8_encode($row['Int_IdGradoInstructor']),
               'nombreGrado'  =>   utf8_encode($row['Vch_Nombre_Grado_Inst'])
            );
        }
         $encabezado=array("gradoConocimiento"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_grado_conocimiento_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}