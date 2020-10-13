<?php
class MVCCurso {

    protected $db;
    protected $conn;
    private $sql;
    private $idCurso;
    private $nombre;
    private $conocimiento;
    private $descripcion;
    private $requistos;
    private $videoPrueba;
    private $rutaVideoActual;
    private $categoria;
    private $nivel;
    private $estadoCurso;
    private $precio;
    private $moneda;
    private $precioPromocion;
    private $instructor;
    private $imagenCurso;
    private $rutaActualImagen;

    public function getId(){return $this->idCurso;}
	public function setId($idCurso){$this->idCurso = $idCurso;	}
    public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;	}
	public function getConocimiento(){return $this->conocimiento;}
	public function setConocimiento($conocimiento){$this->conocimiento = $conocimiento;}
	public function getDescripcion(){	return $this->descripcion;}
	public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
	public function getRequistos(){return $this->requistos;}
	public function setRequistos($requistos){$this->requistos = $requistos;}
	public function getVideoPrueba(){return $this->videoPrueba;}
	public function setVideoPrueba($videoPrueba){$this->videoPrueba = $videoPrueba; }
	public function getRutaVideoActual(){return $this->rutaVideoActual;}
	public function setRutaVideoActual($rutaVideoActual){$this->rutaVideoActual = $rutaVideoActual;}
	public function getCategoria(){return $this->categoria;}
	public function setCategoria($categoria){$this->categoria = $categoria;}
	public function getNivel(){return $this->nivel;}
	public function setNivel($nivel){$this->nivel = $nivel;}
	public function getEstadoCurso(){return $this->estadoCurso;}
	public function setEstadoCurso($estadoCurso){$this->estadoCurso = $estadoCurso;}
	public function getPrecio(){return $this->precio;}
	public function setPrecio($precio){$this->precio = $precio;}
	public function getMoneda(){return $this->moneda;}
	public function setMoneda($moneda){$this->moneda = $moneda;}
	public function getPrecioPromocion(){return $this->precioPromocion;}
	public function setPrecioPromocion($precioPromocion){$this->precioPromocion = $precioPromocion;}
	public function getInstructor(){return $this->instructor;}
	public function setInstructor($instructor){$this->instructor = $instructor;}
	public function getImagenCurso(){return $this->imagenCurso;}
	public function setImagenCurso($imagenCurso){$this->imagenCurso = $imagenCurso;}
	public function getRutaActualImagen(){return $this->rutaActualImagen;}
	public function setRutaActualImagen($rutaActualImagen){$this->rutaActualImagen = $rutaActualImagen;}

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
         $fechaHoy = date('Y-m-d');
        if($this->imagenCurso == null){
            $this->sql = "CALL sp_curso_create_no_imagen('$this->nombre','$this->conocimiento', '$this->descripcion',
                                                        '$this->requistos', '$this->categoria','$this->nivel',
                                                        '$this->precio', '$this->moneda', '$this->instructor', '$fechaHoy',
                                                         '$fechaHoy')";
            $insert = $this->conn->query($this->sql);

        }else{
            $this->sql = "CALL sp_curso_create_imagen('$this->nombre', '$this->conocimiento', '$this->descripcion', 
                                                        '$this->requistos', '$this->categoria','$this->nivel', 
                                                         '$this->precio', '$this->moneda', '$this->instructor', '$fechaHoy',
                                                         '$this->imagenCurso', '$fechaHoy') ";
            $insert = $this->conn->query($this->sql);
            if($insert){
               $ruta = "../src/img/bannerscursos/".$this->imagenCurso;
                move_uploaded_file($this->rutaActualImagen,$ruta);
            }
          
        }
        return $insert;
     }

     public function updateData(){
        $fechaHoy = date('Y-m-d');
       if($this->imagenCurso == null){
           $this->sql = "CALL sp_curso_update('$this->nombre', '$this->conocimiento', '$this->descripcion',
                                               '$this->requistos', '$this->categoria', '$this->nivel', '$this->precio', 
                                               '$this->moneda','$fechaHoy', '$this->idCurso')";
          
           $update = $this->conn->query($this->sql);

       }else{
           $this->sql = "CALL sp_curso_update_image('$this->nombre', '$this->conocimiento', '$this->descripcion',
                                                    '$this->requistos','$this->categoria', '$this->nivel', '$this->precio',
                                                     '$this->moneda' ,'$fechaHoy', '$this->imagenCurso' ,'$this->idCurso' )";
           $insert = $this->conn->query($this->sql);
           if($update){
              $ruta = "../src/img/bannerscursos/".$this->imagenCurso;
               move_uploaded_file($this->rutaActualImagen,$ruta);
           }
         
       }
       return $update;
    }

    public function eliminar(){
        $this->sql = "CALL sp_curso_delete('$this->idCurso') ";
        $delete = $this->conn->query($this->sql);
        return $delete;
    }

    public function publicar(){
        $this->sql = "CALL sp_curso_publicar('$this->idCurso') ";
        $publicacion = $this->conn->query($this->sql);
        return $publicacion;
    }

    public function restaurar(){
        $this->sql = "CALL sp_curso_restaurar('$this->idCurso')";
        $restauracion =  $this->conn->query($this->sql);
        return $restauracion;
    }


     public function showData(){
         $this->sql = "CALL sp_curso_read_profesor('$this->instructor')";
          $search = $this->conn->query($this->sql);
          $curso = array();
         
        while( $row=mysqli_fetch_array($search) ){
            $curso[] = array(
               'id' =>  $row['Int_IdCurso'],
               'nombre'  =>  $row['Vch_Nobre_Curso'],
               'conocimiento' => $row['Vch_Conocimiento_Curso'],
               'descripcion' => $row['VchDescripcion_Curso'],
               'requisitos' => $row['VchRequisitos_Curso'],
               'videoPrueba' => $row['VchVideoPrueba'],
               'categoria' => $row['Int_FkCategoria_Curso'],
               'nivel' => $row['Int_Fk_Nivel_Curso'],
               'estadoCurso' => $row['Int_Estado_Curso'],
               'precio' => $row['Fl_Precio_Curso'],
               'moneda' => $row['Int_FkMoneda_Curso'],
               'precioPromo' => $row['Fk_PrecioPromoCurso'],
               'instructor' => $row['FK_Instructor'],
               'fechaCreacion' => $row['DT_Fecha_Creacion'],
               'imgCurso' => $row['vchImagenCurso'],
               'dateModificacion' => $row['DT_UltimaFecha_modificacion']
            );
        }
         $encabezado=array("curso"=>$curso);
         $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);

       $this->closeConnection();

        return $json_string;
     }

     public function showDataCursoClient(){
        $this->sql = "CALL sp_curso_show_client()";
        $search = $this->conn->query($this->sql);
        $cursoList = array();
        while( $row = mysqli_fetch_array($search) ){
            $cursoList[] = array(
               'id' =>  $row['Int_IdCurso'],
               'idInstructor' => $row['FK_Instructor'],
               'nombre'  =>  $row['Vch_Nobre_Curso'],
               'incritos' => $row['CantidadDeRegistrados'],
               'conocimiento' => $row['Vch_Conocimiento_Curso'],
               'descripcion' => $row['VchDescripcion_Curso'],
               'requisitos' => $row['VchRequisitos_Curso'],
               'categoria' => $row['Vch_CategoriaInst'],
               'nivel' => $row['Vch_Nombre_Nivel'],
               'precio' => $row['Fl_Precio_Curso'],
               'moneda' => $row['VchNombre_Moneda'],
               'imgCurso' => $row['vchImagenCurso'],
               'dateModificacion' => $row['DT_UltimaFecha_modificacion'],
               'instructor' => $row['nombreInstructor'],
               'imgUser' => $row['imgUser']
            );
        }
        $encabezado=array("cursoList"=>$cursoList);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnection();
        return $json_string;
     }

     public function cursoDeatail(){
        $this->sql = "CALL sp_curso_detail('$this->idCurso')";
        $search = $this->conn->query($this->sql);
        $cursoDetalle = array();
        while( $row=mysqli_fetch_array($search) ){
            $cursoDetalle[] = array(
               'id' =>  $row['Int_IdCurso'],
               'idInstructor' => $row['FK_Instructor'],
               'nombre'  =>  $row['Vch_Nobre_Curso'],
               'conocimiento' => $row['Vch_Conocimiento_Curso'],
               'descripcion' => $row['VchDescripcion_Curso'],
               'requisitos' => $row['VchRequisitos_Curso'],
               'categoria' => $row['Vch_categoriaInst'],
               'nivel' => $row['Vch_Nombre_Nivel'],
               'precio' => $row['Fl_Precio_Curso'],
               'moneda' => $row['VchNombre_Moneda'],
               'imgCurso' => $row['vchImagenCurso'],
               'dateModificacion' => $row['DT_UltimaFecha_modificacion'],
               'instructor' => $row['nombreInstructor'],
               'imgUser' => $row['imgUser']
            );
        }
        $encabezado=array("cursoDetail"=>$cursoDetalle);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnection();
        return $json_string;  
     }
 }