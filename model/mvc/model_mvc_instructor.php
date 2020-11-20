<?php
require('conexion.php');
require('conexionPDO.php');
class MVCProfesor{
    protected $db;
    protected $conn;
    protected $sql;
    protected $sql2;
    protected $conexion;
    protected $db2;
    protected $resultado;
    private $idInstructor;
    private $gradoConocimiento;
    private $estancia;
    private $idUsuario;

    //getters y  setter 
    public function getIdInstructor(){
		return $this->idInstructor;
	}

	public function setIdInstructor($idInstructor){
		$this->idInstructor = $idInstructor;
	}

	public function getGradoConocimiento(){
		return $this->gradoConocimiento;
	}

	public function setGradoConocimiento($gradoConocimiento){
		$this->gradoConocimiento = $gradoConocimiento;
	}

	public function getEstancia(){
		return $this->estancia;
	}

	public function setEstancia($estancia){
		$this->estancia = $estancia;
	}

	public function getIdUsuario(){
		return $this->idUsuario;
	}

	public function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario;
    }

    public function __construct(){
        $this->startDB();
    }

    public function startDB(){
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection(); 

        $this->db2 = new ConexionPDO();
        $this->conexion =  $this->db2->Obtener_conexion();
    }

    public function closeConnection(){
        $this->db->closeConnection( $this->conn );
    } 
    
    public function verificarSiEsProfesor(){
        $this->sql = "CALL sp_verificar_si_es_profesor('$this->idUsuario')";
        $buscarInstructor = $this->conn->query($this->sql);
        $result = mysqli_fetch_array($buscarInstructor);
        return $result[0];
    }


    public function registrarProfesor(){
        $this->sql2 = "INSERT INTO tblinstructor(Int_FkUsuario_Inst) VALUES(?);	";
        $this->resultado = $this->conexion->prepare($this->sql2);
        $this->resultado->bindParam(1,$this->idUsuario);
        $this->resultado->execute();

        if($this->resultado){
            return true;
        }
        else{
            return false;
        }
    }
    public function autentificarProfesor(){
        $this->sql2 = "CALL sp_auntentificar_profesor(?)";
        $this->resultado = $this->conexion->prepare($this->sql2);
        $this->resultado->bindParam(1,$this->idUsuario);
        $this->resultado->execute();
        if($this->resultado === false ){
            $res[0] = 0;
            return $res;
        }else{
            $res = $this->resultado->fetch(PDO::FETCH_BOTH);
            return $res;
        }
    }
    public function update(){
        session_start();
        $this->sql = "CALL sp_update_profesor('$this->gradoConocimiento', '$this->estancia', '$this->idInstructor')";
        $_SESSION['gradoConocimiento'] = $this->gradoConocimiento;
        $_SESSION['estancia']          = $this->estancia;
        $actulizar = $this->conn->query( $this->sql );
        return $actulizar;
    }

    public function registrarNuevoProfesor(){
        $registro = $this->registrarProfesor();
        if($registro){
            $arrayDataProfesor = $this->autentificarProfesor();
            if($arrayDataProfesor[0] == 0){
                return '0';
            }else{
                // $_SESSION['idProfesor']        = $arrayDataProfesor[0];
                // $_SESSION['gradoConocimiento'] = $arrayDataProfesor[1];
                // $_SESSION['estancia']          = $arrayDataProfesor[2];
                // $_SESSION['profesor']          = "YES";

                return $arrayDataProfesor;
            }
        }else{
            return 'ErrorRegistro '.$registro;
        }   
    }
}