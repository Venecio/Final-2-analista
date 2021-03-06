<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$apellido = $_POST['apellido'];
	$nombres = $_POST['nombre'];
	$edad = $_POST['edad'];
	$email = $_POST['email'];

	$alumnos = new alumnos();

    if (isset($_POST['modificar'])) {
		$id = $_POST['id'];
	 	echo 'modificar';
		$alumnos->modificar_alumnos($id, $apellido, $nombres, $edad, $email);
	} else {
		echo 'agregar';
		$alumnos->agregar_alumno($apellido, $nombres, $edad, $email);
	}
}


class alumnos{
	private $db;
	private $inscripciones;

	public function __construct(){
		require_once $_SERVER['DOCUMENT_ROOT']."/Proyecto_final/proyecto-final/base_de_datos/db_connect.php";

        $this->db=Conectar::conexion();
        $this->inscripciones=array();
    }
    

	public function agregar_alumno($apellido, $nombres, $edad, $email){
	    $consulta_insertar_alumno = "INSERT INTO alumno(apellido, nombres, edad, email)
	                VALUES ('$apellido','$nombres' ,'$edad', '$email')";
	    $resultado = $this->db->query($consulta_insertar_alumno);
	    if ($resultado){
	    	echo "Datos insertados";
	    	HEADER("location:../vistas/alumnos/lista_alumnos.php");
	    } else {
	    	echo "Los datos no se pudieron insertar";
	    }

	}

	public function modificar_alumnos($id, $apellido, $nombres, $edad, $email){
	    $consulta_modificar_alumno = "UPDATE alumno SET apellido = '$apellido',nombres = '$nombres',edad='$edad',email='$email'
                WHERE id= '$id';";
	    $resultado = $this->db->query($consulta_modificar_alumno);
	    if ($resultado){
	    	echo "Datos modificados";
	    	HEADER("location:../vistas/alumnos/lista_alumnos.php");
	    } else {
	    	echo "Los datos no se pudieron modificar";
	    }
	}


	public function listar_alumnos(){
		$consulta_listar_alumnos = "SELECT * FROM alumno;";
        $consulta=$this->db->query($consulta_listar_alumnos);
        while($filas=$consulta->fetch_assoc()){
            $this->alumnos[]=$filas;
        }
        return $this->alumnos;
    }


	public function listar_alumno_por_id($id){
		$consulta_listar_alumnos = "SELECT * FROM alumno WHERE id = '$id';";
        $consulta=$this->db->query($consulta_listar_alumnos);
        return $consulta->fetch_assoc();
    }

    public function listar_alumnos_acotada(){
		$consulta_listar_alumnos = "SELECT id, CONCAT(CONCAT(apellido, ', '), nombres) as apellidoynombre FROM alumno;";
        $consulta=$this->db->query($consulta_listar_alumnos);
        while($filas=$consulta->fetch_assoc()){
            $this->alumnos[]=$filas;
        }
        return $this->alumnos;
    }
}

