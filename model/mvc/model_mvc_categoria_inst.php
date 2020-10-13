<?php
class  MVCCategoriaInstructor  {
    protected $db;
    protected $conn;
    protected $params;
    private $id;
    private $nombreCategoria;
    private $sql;
 
    public function setNombreCategoria( $nombreCategoria){
        $this->nombreCategoria = $nombreCategoria;

    }

    public function getNombreCategoria( ){
       return $this->nombreCategoria;

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
        $this->sql="CALL sp_categoria_create('$this->nombreCategoria') "; 
        $insert =$this->conn->query( $this->sql);
        $this->closeConnection();
        return $insert; 
    }

    public function updatetData(){
        $this->sql="CALL sp_categoria_update( '$this->nombreCategoria', '$this->id')"; 
        $update = $this->conn->query( $this->sql);
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
        $this->sql="CALL sp_categoria_delete('$this->id')"; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_categoria_read();";  
        $select =  $this->conn->query( $this->sql);
        $categoria = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $categoria[] = array(
               'id' =>  $row['Int_IdCategoria_Inst'],
               'nombreCategoria'  =>  $row['Vch_CategoriaInst']
            );
        }
         $encabezado=array("categoria"=>$categoria);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
    }

    public function countRegister(){
        $this->sql = "SELECT count(*) FROM TblCategoriaInstructor";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
       $this->closeConnection();
        return $total[0];
    }
}