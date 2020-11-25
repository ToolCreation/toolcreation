<?php
require('conexion.php');
require('conexionPDO.php');
class MVCLogin {
    protected $db;
    protected $conn;
    protected $conexion;
    protected $db2;
    protected $resultado;
    private $sql;
    private $sql2;
    private $nombre;
    private $APaterno;
    private $AMaterno;
    private $fechaNacimiento;
    private $edad;
    private $sexo;
    private $email;
    private $telefono;
    private $usuario;
    private $password;
    private $estadoUsuario;
    private $plataforma;
    private $rol;
    private $imagen;
    private $rutaActual;
    private $idUsuario;
    private $tipeFileImg;
   

    //metodos de acceso a propiedades
    public function setIdUsuario( $id ){ $this->idUsuario = $id;  }
    public function getId(){ return $this->idUsuario; }
    public function setNombre($value){ $this->nombre = $value; }
    public function getNombre(){ return $this->nombre; }
    public function setApaterno($value){ $this->APaterno = $value; }
    public function getApaterno(){ return $this->APaterno;  }
    public function setAmaterno($value){ $this->AMaterno = $value; }
    public function getAmaterno(){ return $this->AMaterno;  }
    public function setFechaNacimiento($value) { $this->fechaNacimiento = $value; }
    public function getFechaNacimiento() { return $this->fechaNacimiento; }
    public function setEdad($value) { $this->edad = $value; }
    public function getEdad() { return $this->edad; }
    public function setSexo($value) { $this->sexo = $value; }
    public function getSexo() { return $this->sexo; }
    public function setEmail($value) { $this->email = $value; }
    public function getEmail() { return $this->email; }
    public function setTelefono($value) { $this->telefono = $value; }
    public function getTelefono() { return $this->telefono; }
    public function setUsuario($value) { $this->usuario = $value; }
    public function getUsuario() { return $this->usuario; }
    public function setPassword($value) { $this->password = $value; }
    public function getPassword() { return $this->password; }
    public function setEstadoUsuario($value) { $this->estadoUsuario = $value; }
    public function getEstadoUsuario() { return $this->estadoUsuario; }
    public function setPlataforma($value) { $this->plataforma = $value; }
    public function getPlataforma() { return $this->plataforma; }
    public function setRol($value) { $this->rol = $value; }
    public function getRol() { return $this->rol; }
    public function setImagen($value) { $this->imagen = $value; }
    public function getImagen() { return $this->imagen; }
    public function setRutaActual($value) { $this->rutaActual = $value; }
    public function getRutaActual() { return $this->rutaActual; }
    public function getTipeFileImg(){ return $this->tipeFileImg; }
    public function setTipeFileImg($tipeFileImg){$this->tipeFileImg = $tipeFileImg; }

    public function __construct(){
        $this->startDB();
    }

    public function startDB(){
        $this->db2 = new ConexionPDO();
        $this->conexion =  $this->db2->Obtener_conexion();
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection(); 

        
    }

    public function closeConnection(){
        $this->db->closeConnection( $this->conn );
    } 

    public function obtenerPasswordAndRol(){
        $this->sql = "CALL sp_getPassAndRol('$this->email') ";
        $resultSearchPass = $this->conn->query($this->sql);
        $passwordSearched = mysqli_fetch_array($resultSearchPass);
        return $passwordSearched;
    }

     public function autenticacion($passwordVerificado, $rolVerificado){

        //Verificacion de contraseña
        if(password_verify($this->password, $passwordVerificado)){
                $this->sql2 = "CALL sp_usuario_autentificaion(?,?,?)";
                $this->resultado = $this->conexion->prepare($this->sql2);
                $this->resultado->bindParam(1,$rolVerificado);
                $this->resultado->bindParam(2,$this->email);
                $this->resultado->bindParam(3,$passwordVerificado);
                $this->resultado->execute(); 

                // if($this->resultado === false){
                //     return "fallo la consulta ". $this->conexion->errorInfo();
                   
                // }else{
                //     return "exito";
                // }
                if($this->resultado === false ){
                    $r[0] = 0;
                    return $r;
                }else{
                    $r = $this->resultado->fetch(PDO::FETCH_BOTH);
                    return $r;
                } 
               
        }else{
            $r[0] = false;
            return $r;
        }
        
     }
     
    public function register(){

        $hash = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]);

        $this->sql = "CALL sp_createUsuario('$this->nombre', '$this->APaterno', '$this->AMaterno','$this->fechaNacimiento', '$this->edad', '$this->sexo',
        '$this->email', '$this->telefono', '$this->usuario','$hash')";
        $register = $this->conn->query($this->sql);
        $this->closeConnection();
        return $register;
    }

    public function cerrarSesion(){
        session_unset();
        return session_destroy();
    }

    public function ConfigPersonalAccount(){
        session_start();
        if($this->imagen != null){
                if( ($this->tipeFileImg =='image/jpeg') ||
                ($this->tipeFileImg =='image/png') || 
                ($this->tipeFileImg =='image/jpg') 
                ){
                    $this->sql = "CALL sp_configpersonalaccountImage('$this->nombre', '$this->APaterno', '$this->AMaterno',
                                                                    '$this->fechaNacimiento', '$this->edad','$this->sexo',
                                                                    '$this->telefono', '$this->imagen', '$this->idUsuario') ";
                    $update = $this->conn->query($this->sql);
                    $ruta = "../src/img/perfilUsers/".$this->imagen;
                        if($update){
                            move_uploaded_file($this->rutaActual,$ruta);
                            $_SESSION['nombre']        = $this->nombre;
                            $_SESSION['APaterno']      = $this->APaterno;
                            $_SESSION['AMaterno']      = $this->AMaterno;
                            $_SESSION['FNacimiento']   = $this->fechaNacimiento;
                            $_SESSION['edad']          = $this->edad;
                            $_SESSION['sexo']          = $this->sexo;
                            $_SESSION['imagen']        = $this->imagen;
                            $_SESSION['telefono']      = $this->telefono;
                        }
                }else{
                    $titleMessage = array("msj"=>"errorFile", 
                    "detailError"=>"el archivo no es valido, ingrese una imagen JPG, JPEG, PNG");
                    return json_encode($titleMessage);
                }
                 
            }else{
                $this->sql = "CALL sp_configpersonalacountNotimage('$this->nombre', '$this->APaterno', '$this->AMaterno', 
                                                                      '$this->fechaNacimiento', '$this->edad','$this->sexo',
                                                                       '$this->telefono', '$this->idUsuario') ";
                $update = $this->conn->query($this->sql);
                if($update){
                    $_SESSION['nombre']        = $this->nombre;
                    $_SESSION['APaterno']      = $this->APaterno;
                    $_SESSION['AMaterno']      = $this->AMaterno;
                    $_SESSION['FNacimiento']   = $this->fechaNacimiento;
                    $_SESSION['edad']          = $this->edad;
                    $_SESSION['sexo']          = $this->sexo;
                    $_SESSION['telefono']      = $this->telefono;
                }
                
             
       }
       return $update;
   }

    public function configLogAccount(){
        session_start();
        if($this->password == null){
            $this->sql = "CALL sp_configLogacountNotPassword('$this->email','$this->usuario','$this->idUsuario' ) ";
            $update = $this->conn->query($this->sql);
            if($update){
                $_SESSION['usuario'] = $this->usuario;
                $_SESSION['email']   = $this->email;
            }
            $this->closeConnection();
            return $update;

        }else{
            $hash = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]);
            $this->sql = "CALL sp_configLogacountPassword('$this->email', '$hash', '$this->usuario', '$this->idUsuario')";
            $update = $this->conn->query($this->sql);
           
            if($update){
                $_SESSION['usuario']  = $this->usuario;
                $_SESSION['email']    = $this->email;
                $_SESSION['password'] = $hash;

            }
            $this->closeConnection();
            return $update;
        }
       
    }

    public function comprobarEmail(){
        $this->sql = "CALL sp_comprobarEmail('$this->email')";
        $comprobEmail = $this->conn->query($this->sql);
        $total = mysqli_fetch_array($comprobEmail);
        if($total[0] == null){
            $this->closeConnection();
            return json_encode(array("msj"=>"No existe"));
           
        }else{
            $this->closeConnection();
            return json_encode(array("msj"=>"Existe"));
        }
    }

    public function comprobarUsuario(){
        $this->sql = "CALL sp_comprobarNameUser('$this->usuario')";
        $comprobarUser = $this->conn->query($this->sql);
        $result = mysqli_fetch_array($comprobarUser);
        if($result[0] == null){
            $this->closeConnection();
            return json_encode(array("msj"=>"No existe"));
        }else{
            $this->closeConnection();
            return json_encode(array("msj"=>"Existe"));
        }
    }

    public function restorePass(){
        $hash = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]);
        $this->sql = "CALL sp_restorePass('$hash', '$this->email') ";
        $updatePass = $this->conn->query($this->sql);
        return $updatePass;
    }
   

    
   
}
 