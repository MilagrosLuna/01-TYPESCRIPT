<?php   
namespace ManejoDeAlumnos;
use \Exception;
class Alumnos
{
    private string $_nombre;
	private string $_apellido;
    private int $_legajo;
	private string $_foto;
	// no me acuerdo si hay propiedades
	public function Nombre():string{
		return $this->_nombre;
	}
	public function Apellido():string{
		return $this->_apellido;
	}
	public function Legajo():int{
		return $this->_legajo;
	}
	public function Foto():string{
		return $this->_foto;
	}
	public function __construct(string $_nombre, string $_apellido,int $_legajo,string $_foto)
	{
		$this->_nombre = $_nombre;
		$this->_apellido = $_apellido;
		$this->_legajo = $_legajo;		
		$foto_path = $this->_legajo . '.' . pathinfo($_foto, PATHINFO_EXTENSION);
		$this->_foto = $foto_path;
	}
    public static function agregar(Alumnos $obj) : bool {
		$retorno = false;
		if(!alumnos::buscarPorLegajo($obj->_legajo))
		{
			//ABRO EL ARCHIVO
			$ar = fopen("./archivos/alumnos_foto.txt", "a");//A - append
			//ESCRIBO EN EL ARCHIVO CON FORMATO: CLAVE-VALOR_UNO-VALOR_DOS
			$cant = fwrite($ar, "{$obj->_legajo}-{$obj->_apellido}-{$obj->_nombre}-{$obj->_foto}\r\n");
			if($cant > 0)
			{
				$retorno = true;						
			}else{throw new Exception('hubo un problema con el archivo');}
			//CIERRO EL ARCHIVO
			fclose($ar);
		}else{throw new Exception('el alumno ya esta agregado');}				
		return $retorno;
	}
	public static function listar() : string {
		$retorno = "";
		$retorno .= "<h1>LISTADO DE ALUMNOS</h1>";		
		$alumnos = file('./archivos/alumnos_foto.txt');

		foreach ($alumnos as $linea) {
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
		
			if($array_linea[0] != ""){
				$_foto = trim($array_linea[3]);
				$retorno .= "<br>" .  $linea . "<br>";
				$retorno .= "<img src='./fotos/$_foto' width='200'> <br>";
			}
		}		
		
		return $retorno;
	}
	
	public static function buscarPorLegajo(int $legajo) : bool {
		$retorno = false;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				//RECUPERO LOS CAMPOS
				$_legajo = trim($array_linea[0]);
				if ($_legajo == $legajo) {$retorno = true;}
			}
		}
		return $retorno;
	}

	public static function modificar(alumnos $obj) : bool {
		$retorno = false;
		$elementos = array();
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				$_legajo = trim($array_linea[0]);
				$_apellido = trim($array_linea[1]);
				$_nombre = trim($array_linea[2]);
				$_foto = trim($array_linea[3]);
				if ($_legajo == $obj->_legajo) { array_push($elementos, "{$_legajo}-{$obj->_nombre}-{$obj->_apellido}-{$obj->_foto}\r\n");}
				else{array_push($elementos, "{$_legajo}-{$_nombre}-{$_apellido}-{$_foto}\r\n");}
			}
		}
		fclose($ar);
		$ar = fopen("./archivos/alumnos_foto.txt", "w");
		$cant = 0;		
		foreach($elementos AS $item){
			$cant = fwrite($ar, $item);
		}
		if($cant > 0)
		{
			$retorno = true;			
		}
		fclose($ar);
		return $retorno;
	}

	public static function borrar(int $_legajo) : bool {

		$retorno = false;
		$elementos = array();
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				$legajo_archivo = trim($array_linea[0]);
				$apellido_archivo = trim($array_linea[1]);
				$nombre_archivo = trim($array_linea[2]);
				$foto_archivo = trim($array_linea[3]);
				if ($legajo_archivo == $_legajo) 
				{
					if (unlink("./fotos/".$foto_archivo)) {
						echo 'La foto del alumno se ha borrado exitosamente.<br>';
					  } 
					continue;
				}
				
				array_push($elementos, "{$legajo_archivo}-{$nombre_archivo}-{$apellido_archivo}-{$foto_archivo}\r\n");
			}
		}
		fclose($ar);
		$cant = 0;
		$ar = fopen("./archivos/alumnos_foto.txt", "w");
		foreach($elementos AS $item){

			$cant = fwrite($ar, $item);
		}
		if($cant >= 0)
		{
			$retorno = true;			
		}
		fclose($ar);
		return $retorno;
	}

	public static function obtener(int $legajo) : alumnos {
		$retorno = null ;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				$_legajo = trim($array_linea[0]);
				$_apellido = trim($array_linea[1]);
				$_nombre = trim($array_linea[2]);
				$_foto = trim($array_linea[3]);
				if ($_legajo == $legajo){
					$retorno = new alumnos( $_nombre, $_apellido,(int)$_legajo, $_foto);
				}
			}
		}
		return $retorno;
	}

}
?>