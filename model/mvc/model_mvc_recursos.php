<?php
require('conexion.php');
class MVCRecursos
{
    private $db;
    private $conn;
    protected $sql;
    private $id;
    private $nombre;
    private $url;
    private $video;
    private $tipo;
    private $idCurso;
 
    public function getId() { return $this->id; }

    public function setId($id){ $this->id = $id; }

    public function getNombre(){ return $this->nombre; }
    
    public function setNombre($nombre){  $this->nombre = $nombre; }

    public function getUrl(){ return $this->url;}

    public function setUrl($url){  $this->url = $url;  }
 
    public function getTipo() { return $this->tipo; }

    public function setTipo($tipo){ $this->tipo = $tipo; }

    public function getVideo(){return $this->video;}

    public function setVideo($video){ $this->video = $video;}
   
    public function getIdCurso() {  return $this->idCurso;}

    public function setIdCurso($idCurso) { $this->idCurso = $idCurso;}

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

    public function insertar(){
        $this->sql = "CALL sp_recursos_create('$this->nombre','$this->url',
                                            '$this->video','$this->tipo')";
        $insert = $this->conn->query($this->sql);
        $this->closeConnection();
        return $insert;  
    }
    public function actualizar(){
       $this->sql = "CALL sp_recursos_update('$this->nombre','$this->url',
                                            '$this->video','$this->tipo', '$this->id')";
        $update = $this->conn->query($this->sql);
        $this->closeConnection();
        return $update;  
    }
    public function eliminar(){
        $this->sql = "CALL sp_recursos_delete('$this->id') ";
        $delete = $this->conn->query($this->sql);
        return $delete;
    }
    public function contarRegistros(){
        $this->sql = "CALL sp_recursos_count('$this->idCurso')";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
    public function listarRegistros(){
        $this->sql = "CALL sp_recursos_read('$this->idCurso')";
   
        $search = $this->conn->query($this->sql);
        $recursos = array();
       
      while( $row=mysqli_fetch_array($search) ){
          $recursos [] = array(
             'idRecurso' =>   utf8_encode($row['idRecurso']),
             'idTipoRecurso'  =>  utf8_encode( $row['idTipoRecurso']),
             'idVideo' =>  utf8_encode($row['idVideo']),
             'nombreVideo' =>  utf8_encode($row['nombreVideo']),
             'tipoRecurso' =>  utf8_encode($row['tipoRecurso']),
             'nombreRecurso' =>  utf8_encode($row['nombreRecurso']),
             'URL' =>   utf8_encode($row['URL'])
          );
      }
       $head=array("recursos"=>$recursos);
       $json_string = json_encode($head,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

       return $json_string;
    }
  
}
