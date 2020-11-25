<?php
require('conexion.php');
class MVCTemas{
   protected $db;
   protected $conn;
   private $sql;
   private $idTema;
   private $nombre;
   private $descripcion;
   private $idCurso;
   private $estado;
   public function getIdTema(){return $this->idTema;}
	public function setIdTema($idTema){	$this->idTema = $idTema;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){	$this->nombre = $nombre;}
	public function getDescripcion(){return $this->descripcion;}
	public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
	public function getIdCurso(){return $this->idCurso;}
	public function setIdCurso($idCurso){$this->idCurso = $idCurso;}
	public function getEstado(){	return $this->estado;}
	public function setEstado($estado){$this->estado = $estado;}

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


     public function insert(){
        $this->sql="CALL sp_tema_create('$this->nombre', '$this->descripcion','$this->idCurso') "; 
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;
     }

     public function update(){
        $this->sql="CALL sp_tema_update( '$this->nombre','$this->descripcion','$this->idTema')"; 
        $update = $this->conn->query($this->sql);
        $this->closeConnection();
        return $update;
     }

     public function delete(){
        $this->sql="CALL sp_tema_delete('$this->idTema')"; 
        $delete = $this->conn->query($this->sql);
        $this->closeConnection();
        return $delete;
     }

     public function getData(){
        $this->sql = "CALL sp_tema_read('$this->idCurso')";
   
         $search = $this->conn->query($this->sql);
         $tema = array();
        
       while( $row=mysqli_fetch_array($search) ){
           $tema[] = array(
              'id' =>   utf8_encode($row['Int_Id_Tema_Curso']),
              'nombre'  =>  utf8_encode( $row['Vch_Nombre_Tema_C']),
              'descripcion' =>  utf8_encode($row['Vch_Descripcion_T']),
              'estado' =>  utf8_encode($row['Int_VchEstado_T']),
              'idCurso' =>  utf8_encode($row['Int_FkCurso'])
           );
       }
        $encabezado=array("temas"=>$tema);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

      $this->closeConnection();

       return $json_string;
    }

     public function countRegister(){
         $this->sql = "CALL sp_tema_count('$this->idCurso')";
         $count = $this->conn->query( $this->sql);
         $total = mysqli_fetch_array($count);
         $this->closeConnection();
         return $total[0];
        
     }
     public function insertTemaVisto($estudiante){
      $this->sql = "CALL sp_temavisto_create('$this->idTema','$estudiante')";
      $insertar = $this->conn->query( $this->sql);
      $this->closeConnection();
      return $insertar;
     }

}