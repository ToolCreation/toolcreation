<?php
class MVCNivel{
    protected $conn;
    protected $params;
    private $sql;
    private $id;
    private $nivel;
 
    public function setNombreNivel( $nivel ){
        $this->nivel = $nivel;
    }

    public function getNombreNivel(){
       return $this->nivel;
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
        $this->sql="CALL sp_nivel_create('$this->nivel')"; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_nivel_update('$this->nivel','$this->id')"; 
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
        $this->sql="CALL sp_nivel_delete('$this->id')"; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_nivel_read()";  
        $select = $this->conn->query($this->sql);
        $colecciones = array();
        while( $row=mysqli_fetch_array($select) ){
            $colecciones[] = array(
               'id' =>   utf8_encode($row['Int_IdNivel_Curso']),
               'nombreNivel'  =>   utf8_encode($row['Vch_Nombre_Nivel'])
            );
        }
         $encabezado=array("estadoNivel"=>$colecciones);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_nivel_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}