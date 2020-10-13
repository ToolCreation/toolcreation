<?php
class MVCMoneda {
    protected $db;
    protected $conn;
    private $id;
    private $nombreMoneda;
    private $valorMoneda;
    protected $params;
    private $sql;

    public function setData( $nombreMoneda, $valorMoneda){
        $this->nombreMoneda = $nombreMoneda;
        $this->valorMoneda = $valorMoneda;
    }

    public function setId( $id ){
        $this->id = $id;
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
        $this->sql="CALL sp_moneda_create('$this->nombreMoneda','$this->valorMoneda')"; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
    }

    public function updatetData(){
        $this->sql="CALL sp_moneda_update('$this->nombreMoneda','$this->valorMoneda','$this->id')"; 
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
        $this->sql="CALL sp_moneda_delete('$this->id') "; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
    }
    

    public function getData(){
       $this->sql="CALL sp_moneda_read()";  
        $select = $this->conn->query($this->sql);
        $moneda = array();
        while( $row=mysqli_fetch_array($select) ){
            $moneda[] = array(
               'id' =>  $row['Int_Id_Moneda'],
               'nombreMoneda'  =>  $row['VchNombre_Moneda'],
               'valor' =>  $row['Fl_Valor_Moneda']
            );
        }
         $encabezado=array("moneda"=>$moneda);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

        $this->closeConnection();
        return $json_string;
    }

    public function countRegister(){
        $this->sql = "CALL sp_moneda_count()";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
}