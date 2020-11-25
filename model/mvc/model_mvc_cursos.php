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
    private $tipoImagen;
    private $tipoVideo;

   

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
        if($this->imagenCurso == null && $this->videoPrueba == null){
            $this->sql = "CALL sp_curso_create_no_imagen('$this->nombre','$this->conocimiento', '$this->descripcion',
                                                        '$this->requistos', '$this->categoria','$this->nivel',
                                                        '$this->precio', '$this->moneda', '$this->instructor', '$fechaHoy',
                                                         '$fechaHoy')";
            $insert = $this->conn->query($this->sql);

        }else{
            if( ($this->tipoImagen["type"]=='image/jpeg') ||
                ($this->tipoImagen["type"]=='image/png') || 
                ($this->tipoImagen["type"]=='image/jpg') ||
                ($this->tipoVideo["type"]=='video/mpeg') ||
                ($this->tipoVideo["type"]=='video/ogg') ||
                ($this->tipoVideo["type"]=='video/mp4')
                ){
                $this->sql = "CALL sp_curso_create_imagen('$this->nombre', '$this->conocimiento', '$this->descripcion', 
                                                        '$this->requistos', '$this->categoria','$this->nivel', 
                                                         '$this->precio', '$this->moneda', '$this->instructor', '$fechaHoy',
                                                         '$this->imagenCurso', '$fechaHoy', '$this->videoPrueba') ";
            }else{
                $titleMessage = array("msj"=>"errorFile", 
                                      "detailError"=>"el archivo no es valido, ingrese una imagen o video valido");
                    return json_encode($titleMessage);
            }
           
            $insert = $this->conn->query($this->sql);
            if($insert){
                if($this->imagenCurso != null){
                    $rutaImagen = "../src/img/bannerscursos/".$this->imagenCurso;
                    move_uploaded_file($this->rutaActualImagen,$rutaImagen);
                }
                if($this->videoPrueba != null){
                    $rutaVideo = "../src/videos/cursos/".$this->videoPrueba;
                    move_uploaded_file($this->rutaVideoActual,$rutaVideo);
                }
                 
            }
          
        }
        return $insert;
     }

     public function updateData(){
        $fechaHoy = date('Y-m-d');
       if($this->imagenCurso == null && $this->videoPrueba == null){
           $this->sql = "CALL sp_curso_update('$this->nombre', '$this->conocimiento', '$this->descripcion',
                                               '$this->requistos', '$this->categoria', '$this->nivel', '$this->precio', 
                                               '$this->moneda','$fechaHoy', '$this->idCurso')";
          
           $update = $this->conn->query($this->sql);

       }else{
            if( ($this->tipoImagen =='image/jpeg') ||
                ($this->tipoImagen =='image/png') || 
                ($this->tipoImagen =='image/jpg') ||
                ($this->tipoVideo == 'video/mpeg') ||
                ($this->tipoVideo =='video/ogg') ||
                ($this->tipoVideo =='video/mp4')
            ){
                $this->sql = "CALL sp_curso_update_image('$this->nombre', '$this->conocimiento', '$this->descripcion',
                                                    '$this->requistos','$this->categoria', '$this->nivel', '$this->precio',
                                                     '$this->moneda' ,'$fechaHoy', '$this->imagenCurso' ,'$this->idCurso', '$this->videoPrueba' )";
            }else{
                $titleMessage = array("msj"=>"errorFile", 
                "detailError"=>"el archivo no es valido, ingrese una imagen o video valido");
                return json_encode($titleMessage);
            }
           
           $update = $this->conn->query($this->sql);
           if($update){
               if($this->imagenCurso != null){
                $ruta = "../src/img/bannerscursos/".$this->imagenCurso;
                move_uploaded_file($this->rutaActualImagen,$ruta);
               }
             
               if($this->videoPrueba != null){
                $rutaVideo = "../src/videos/cursos/".$this->videoPrueba;
                move_uploaded_file($this->rutaVideoActual,$rutaVideo);
               }
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
               'id' =>   utf8_encode($row['Int_IdCurso']),
               'idInstructor' =>  utf8_encode($row['FK_Instructor']),
               'nombre'  =>   utf8_encode($row['Vch_Nobre_Curso']),
               'incritos' =>  utf8_encode($row['CantidadDeRegistrados']),
               'conocimiento' =>  utf8_encode($row['Vch_Conocimiento_Curso']),
               'descripcion' =>  utf8_encode($row['VchDescripcion_Curso']),
               'requisitos' =>  utf8_encode($row['VchRequisitos_Curso']),
               'categoria' =>  utf8_encode($row['Vch_CategoriaInst']),
               'nivel' =>  utf8_encode($row['Vch_Nombre_Nivel']),
               'precio' =>  utf8_encode($row['Fl_Precio_Curso']),
               'moneda' =>  utf8_encode($row['VchNombre_Moneda']),
               'imgCurso' =>  utf8_encode($row['vchImagenCurso']),
               'dateModificacion' =>  utf8_encode($row['DT_UltimaFecha_modificacion']),
               'instructor' =>  utf8_encode($row['nombreInstructor']),
               'imgUser' => utf8_encode( $row['imgUser'])
            );
        }
        $encabezado=array("cursoList"=>$cursoList);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnection();
        return $json_string;
     }

     public function filterCurseForCategory(){
        $this->sql = "CALL sp_curso_read_category('$this->categoria')";
        $search = $this->conn->query($this->sql);
        $cursoListFilter = array();
        while( $row = mysqli_fetch_array($search) ){
            $cursoListFilter[] = array(
               'id' =>   utf8_encode($row['Int_IdCurso']),
               'idInstructor' =>  utf8_encode($row['FK_Instructor']),
               'nombre'  =>   utf8_encode($row['Vch_Nobre_Curso']),
               'incritos' =>  utf8_encode($row['CantidadDeRegistrados']),
               'conocimiento' =>  utf8_encode($row['Vch_Conocimiento_Curso']),
               'descripcion' =>  utf8_encode($row['VchDescripcion_Curso']),
               'requisitos' =>  utf8_encode($row['VchRequisitos_Curso']),
               'categoria' =>  utf8_encode($row['Vch_CategoriaInst']),
               'nivel' =>  utf8_encode($row['Vch_Nombre_Nivel']),
               'precio' =>  utf8_encode($row['Fl_Precio_Curso']),
               'moneda' =>  utf8_encode($row['VchNombre_Moneda']),
               'imgCurso' =>  utf8_encode($row['vchImagenCurso']),
               'dateModificacion' =>  utf8_encode($row['DT_UltimaFecha_modificacion']),
               'instructor' =>  utf8_encode($row['nombreInstructor']),
               'imgUser' => utf8_encode( $row['imgUser']),
               
            );
        }
        $encabezado=array("cursoList"=>$cursoListFilter);
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
               'id' =>   utf8_encode($row['Int_IdCurso']),
               'idInstructor' => utf8_encode($row['FK_Instructor']),
               'nombre'  =>   utf8_encode($row['Vch_Nobre_Curso']),
               'conocimiento' =>  utf8_encode($row['Vch_Conocimiento_Curso']),
               'descripcion' =>  utf8_encode($row['VchDescripcion_Curso']),
               'requisitos' =>  utf8_encode($row['VchRequisitos_Curso']),
               'categoria' =>  utf8_encode($row['Vch_categoriaInst']),
               'nivel' =>  utf8_encode($row['Vch_Nombre_Nivel']),
               'precio' =>  utf8_encode($row['Fl_Precio_Curso']),
               'moneda' =>  utf8_encode($row['VchNombre_Moneda']),
               'imgCurso' =>  utf8_encode($row['vchImagenCurso']),
               'dateModificacion' =>  utf8_encode($row['DT_UltimaFecha_modificacion']),
               'instructor' =>  utf8_encode($row['nombreInstructor']),
               'imgUser' =>  utf8_encode($row['imgUser']),
               'videoPresentacion' => utf8_encode( $row['videoPresentacion'])
            );
        }
        $encabezado=array("cursoDetail"=>$cursoDetalle);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnection();
        return $json_string;  
     }
     public function obtenerPorcentaje($estudiante){
        $this->sql = "SELECT fn_calcularPorcentajeCurso('$this->idCurso', '$estudiante') AS porcentaje";
        $calcular = $this->conn->query($this->sql);
        $porcentaje = mysqli_fetch_array($calcular);
        $this->closeConnection();
        return $porcentaje[0];
     }

   
    public function getTipoImagen()
    {
        return $this->tipoImagen;
    }

    public function setTipoImagen($tipoImagen)
    {
        $this->tipoImagen = $tipoImagen;
    }

     
    public function getTipoVideo()
    {
        return $this->archivoVideo;
    }

   
    public function setTipoVideo($tipoVideo)
    {
        $this->tipoVideo = $tipoVideo;
    }
 }