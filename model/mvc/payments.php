<?php
require('conexion.php');

class MVCPayment{
    protected $db;
    protected $conn;
    private $sql;
    private $estudiante;
    private $curso;
    private $moneda;
    private $transaction;

    public function getCurso(){
        return $this->curso;
    }
    
    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function getMoneda(){
        return $this->moneda;
    }

    public function setMoneda($moneda){
        $this->moneda = $moneda;
    }

    public function getTransaction(){
        return $this->transaction;
    }
    public function setTransaction($transaction){
        $this->transaction = $transaction;
    }

    public function getEstudiante() {
        return $this->estudiante;
    }

    public function setEstudiante($estudiante){
        $this->estudiante = $estudiante;
    }

    public function __construct(){
        $this->startDB();
    }

    public function startDB(){
        $this->db = new Conexion();
        $this->conn = $this->db->getConnection();
    }

    public function closeConnectionDB(){
        $this->db->closeConnection( $this->conn );
    }  

    public function realizar(){
        $this->sql = "CALL sp_payments('$this->curso', '$this->estudiante', '$this->transaction','$this->moneda')";
        $pago = $this->conn->query($this->sql);
        $this->closeConnectionDB();
        return $pago;
    }
    public function verificarEstadoVentaCurso(){
        $this->sql = "SELECT fn_verificarCursoComprado('$this->curso', '$this->estudiante')";
        $verificar = $this->conn->query($this->sql);
        $estado = mysqli_fetch_array($verificar);
        $this->closeConnectionDB();
        return $estado[0];
    }
    public function showCursosPayments(){
        $this->sql = "CALL sp_deatailCursoPayment('$this->estudiante')";
        $search = $this->conn->query($this->sql);
        $cursoList = array();
        while( $row = mysqli_fetch_array($search) ){
            $cursoList[] = array(
               'idVenta' =>   utf8_encode($row['idVenta']),
               'idVentaDetalle' =>  utf8_encode($row['idVentaDetalle']),
               'nombreCurso'  =>   utf8_encode($row['nombreCurso']),
               'costo' =>  utf8_encode($row['costo']),
               'moneda' =>  utf8_encode($row['moneda']),
               'imagenCurso' =>  utf8_encode($row['imagenCurso']),
               'idCurso' =>  utf8_encode($row['idCurso']),
               'idInstructor' =>  utf8_encode($row['idInstructor']),
               'idEstudainte' =>  utf8_encode($row['idEstudainte']),
               'idTransaccion' =>  utf8_encode($row['idTransaccion']),
               'porcentaje' =>  utf8_encode($row['porcentaje']),
               'nameInstructor' =>  utf8_encode($row['nameInstructor']),
               'imgPerfilIntructor' =>  utf8_encode($row['imgPerfilIntructor']),
               'fechaCompra' =>  utf8_encode($row['fechaCompra'])
            );
        }
        $encabezado=array("cursoListPayments"=>$cursoList);
        $json_string = json_encode($encabezado,JSON_UNESCAPED_UNICODE);
        $this->closeConnectionDB();
        return $json_string;
     }
}