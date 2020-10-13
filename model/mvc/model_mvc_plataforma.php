<?php 
require ('conexion.php');
class  MVCPlataforma { 
    protected $db;
    protected $conn;
    private $idPlataforma;
    private $nombrePlataforma;
    private $objetivosPlataforma;
    private $metasPlataforma;
    private $misionPlataforma;
    private $visionPlataforma;
    private $descripcionEmpresa;
    protected $params;
    private $sql;

    //metodo set para los valores 
    public function setData($nombrePlataforma, $objetivosPlataforma, $metasPlataforma, $misionPlataforma, $visionPlataforma, $descripcionEmpresa){
        $this->nombrePlataforma =  $nombrePlataforma;
        $this->objetivosPlataforma =  $objetivosPlataforma;
        $this->metasPlataforma =  $metasPlataforma;
        $this->misionPlataforma =  $misionPlataforma;
        $this->visionPlataforma =  $visionPlataforma;
        $this->descripcionEmpresa =  $descripcionEmpresa;
    }

    public function setId($idPlataforma){
        $this->idPlataforma =  $idPlataforma;
    }

    //inicializamos la instancia conexion
    public function __construct(){
        $this->startDB();
    } 

    //metodo que instancia la conexion
    public function startDB(){
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection(); 
    }
    
    public function closeConnection(){
        $this->db->closeConnection( $this->conn );
     }  

    
    public function insertData(){
       //sentencia SQL los ? representan el espacio de los valores donde se colocaran las variables
       $this->sql="CALL sp_plataforma_create(
        '$this->nombrePlataforma',  '$this->objetivosPlataforma',
        '$this->metasPlataforma', '$this->misionPlataforma',
        '$this->visionPlataforma', '$this->descripcionEmpresa'
       );"; 

        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_plataforma_update('$this->nombrePlataforma',  '$this->objetivosPlataforma',
                                             '$this->metasPlataforma', '$this->misionPlataforma',
                                             '$this->visionPlataforma', '$this->descripcionEmpresa',
                                             '$this->idPlataforma') "; 
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
        $this->sql="CALL sp_plataforma_delete('$this->idPlataforma')"; 
        $delete = $this->conn->query($this->sql);
       $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
      
       $this->sql="CALL sp_plataforma_read()";  
        $select = $this->conn->query($this->sql);
        $plataforma = array();
         
        while( $row=mysqli_fetch_array($select) ){
            $plataforma[] = array(
               'id' =>  $row['Int_Id_Plataforma'],
               'nombrePlataforma'  =>  $row['Vch_NombrePlataforma'],
               'objetivosPlataforma' =>  $row['Vch_Objetivos_Plataforma'],
               'metasPlataforma' =>$row['Vch_Metas_Plataforma'],
               'misionPlataforma' => $row['Vch_Mision_Plataforma'],
               'visionPlataforma' =>  $row['Vch_Vision_Plataforma'],
               'descripcionEmpresa' => $row['Vch_Descripcion_Empresa']
            );
        }
         $encabezado=array("plataforma"=>$plataforma);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

        $this->closeConnection();
        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_plataforma_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
       $this->closeConnection();
        return $total[0];
    }
}