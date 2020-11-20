<?php
require('conexion.php');
class MVCVideos
{
    private $db;
    private $conn;
    protected $sql;
    private $id;
    private $nombre;
    private $url;
    // private $rutaActual;
    // private $videoFile;
    private $fecha;
    private $tema;
    private $tipo;
    private $idCurso;

    public function getIdCurso() {  return $this->idCurso;}

    public function setIdCurso($idCurso) { $this->idCurso = $idCurso;}
 
    public function getId() { return $this->id; }

    public function setId($id){ $this->id = $id; }

    public function getNombre(){ return $this->nombre; }
    
    public function setNombre($nombre){  $this->nombre = $nombre; }

    public function getUrl(){ return $this->url;}

    public function setUrl($url){  $this->url = $url;  }

    public function getFecha(){return $this->fecha;}

    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getTema() { return $this->tema; }

    public function setTema($tema) {$this->tema = $tema; }
 
    public function getTipo() { return $this->tipo; }

    public function setTipo($tipo){ $this->tipo = $tipo; }

    public function getRutaActual(){return $this->rutaActual;}

    public function setRutaActual($rutaActual){ $this->rutaActual = $rutaActual;}
    
    public function getVideoFile(){ return $this->videoFile; }

    public function setVideoFile($videoFile) {$this->videoFile = $videoFile; }

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
        $fechaHoy = date('Y-m-d');
        // if($this->videoFile == null){
        //     $this->sql = "CALL sp_video_create('$this->nombre','$fechaHoy','$this->url',
        //                                         '$this->tema','$this->tipo')";
        // }else{
        //     $this->sql = "CALL sp_video_create('$this->nombre','$fechaHoy','$this->videoFile',
        //                                         '$this->tema','$this->tipo')";       
        // }
        $this->sql = "CALL sp_video_create('$this->nombre','$fechaHoy','$this->url',
                                            '$this->tema','$this->tipo')";
        $insert = $this->conn->query($this->sql);

        // if($insert){
        //     if($this->videoFile != null){
        //         $ruta = "../src/videos/cursos".$this->videoFile;
        //         move_uploaded_file($this->rutaActual, $ruta);
        //     }
        // }
        $this->closeConnection();
        return $insert;  
    }
    public function actualizar(){
        $this->sql = "CALL sp_videos_update('$this->nombre','$this->url','$this->tema','$this->tipo', '$this->id')";
        $update = $this->conn->query($this->sql);
        $this->closeConnection();
        return $update;  
    }
    public function eliminar(){
        $this->sql = "CALL sp_video_delete('$this->id') ";
        $delete = $this->conn->query($this->sql);
        return $delete;
    }
    public function contarRegistros(){
        $this->sql = "CALL sp_video_count('$this->idCurso')";
        $count = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($count);
        $this->closeConnection();
        return $total[0];
    }
    public function listarRegistros(){
        $this->sql = "CALL sp_video_read('$this->idCurso')";
   
        $search = $this->conn->query($this->sql);
        $videos = array();
       
      while( $row=mysqli_fetch_array($search) ){
          $videos [] = array(
             'idVideo' =>  utf8_encode( $row['idVideo']),
             'idTema'  =>   utf8_encode($row['idTema']),
             'idTipoVideo' => utf8_encode( $row['idTipoVideo']),
             'nombreTema' =>  utf8_encode($row['nombreTema']),
             'nombreVideo' =>  utf8_encode($row['nombreVideo']),
             'URLvideo' =>  utf8_encode($row['URLvideo']),
             'tipoVideo' => utf8_encode( $row['tipoVideo']),
          );
      }
       $head=array("videos"=>$videos);
       $json_string = json_encode($head,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

       return $json_string;
    }


   

    
}
