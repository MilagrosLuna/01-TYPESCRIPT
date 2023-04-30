<?php   
namespace ManejoDeAlumnos;
use \Exception;
use PDO;
use PDOException;

class AlumnoBD
{
// #region atributos propiedades y constructor   
	private string $_nombre;
	private string $_apellido;
    private int $_legajo;
    private int $_id;
	private string $_foto;

	public function Id():int{
		return $this->_id;
	}
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
		$this->_nombre = $_nombre != null ? $_nombre : "";
		$this->_apellido = $_apellido != null ? $_apellido : "";
		$this->_legajo = $_legajo != null ? $_legajo :0;	
		$this->_id = 0;		
		$this->_foto = $_foto != null ? $_foto : "";
	}

    public function mostrarAlumno() : string {
        return $this->_id . " - ". $this->_legajo . " - " . $this->_apellido . " - " . $this->_nombre . " - " . $this->_foto ." - ";
      }

    public function existeBD($array)
	{
		$retorno = false;
		foreach($array as $alumnos)
		{
			if($alumnos == $this)
			{
				$retorno = true;
			}
		}
		return $retorno;
	}
	public static function obtenerAlumnoBD($legajo)
    {
		$id=-1;
		$alumnos = AlumnoBD::listarBD();
		foreach($alumnos as $alumno)
		{
			if($alumno->_legajo == $legajo)
			{
				$id = $alumno->_id;
				break;
			}
		}
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM alumnos WHERE id=:id");
        $consulta->bindValue(':id',  $id, PDO::PARAM_INT);
        $consulta->execute();
        $fila=$consulta->fetch();
        if($fila!==null)
        {
            $alumno= new AlumnoBD($fila[3], $fila[2], $fila[1], $fila[4]);
			$alumno->_id=$id;
        }
		else{
			$alumno = new AlumnoBD("","",0,"");
			$alumno->_id=-1;
		}
        return $alumno;
    }


	public static function agregarBD(AlumnoBD $obj):bool{	
		$retorno = false;
		$alumnos = AlumnoBD::listarBD();
		if(!$obj->existeBD($alumnos))
		{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
			$consulta =$objetoAccesoDato->retornarConsulta("INSERT INTO alumnos (legajo, apellido, nombre, foto)"
													. "VALUES(:legajo, :apellido, :nombre, :foto)");
			
			$consulta->bindValue(':legajo', $obj->_legajo, PDO::PARAM_INT);
			$consulta->bindValue(':apellido', $obj->_apellido, PDO::PARAM_STR);
			$consulta->bindValue(':nombre', $obj->_nombre, PDO::PARAM_STR);
			$consulta->bindValue(':foto', $obj->_foto, PDO::PARAM_STR);
			$retorno = $consulta->execute();
		}  		
		return $retorno;
	}
	public static function modificarBD(AlumnoBD $obj):bool{		

		$retorno = false;
		$id=-1;
		$alumnos = AlumnoBD::listarBD();
		foreach($alumnos as $alumno)
		{
			if($alumno->_legajo == $obj->_legajo)
			{
				$id = $alumno->_id;
			}
		}
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->retornarConsulta("UPDATE alumnos SET legajo=:legajo,apellido=:apellido,nombre=:nombre,foto=:foto WHERE id = :id"); 
		$consulta->bindValue(':id', $id, PDO::PARAM_INT);
		$consulta->bindValue(':legajo', $obj->_legajo, PDO::PARAM_INT);
		$consulta->bindValue(':apellido', $obj->_apellido, PDO::PARAM_STR);
		$consulta->bindValue(':nombre', $obj->_nombre, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $obj->_foto, PDO::PARAM_STR);
		$retorno = $consulta->execute();
		 		
		return $retorno;
 		
	}
	public static function borrarBD(int $legajo):bool{		
		$id=-1;
		$foto_archivo = "";
		$alumnos = AlumnoBD::listarBD();
		foreach($alumnos as $alumno)
		{
			if($alumno->_legajo == $legajo)
			{
				$id = $alumno->_id;
				$foto_archivo = $alumno->_foto;
			}
		}
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM alumnos WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);	

		if (unlink("./fotosBD/".$foto_archivo)) {
			echo 'La foto del alumno se ha borrado exitosamente.<br>';
		  } 	

        return $consulta->execute();   		
	}

	public function toArray() {
		return [
			'_nombre' => $this->_nombre,
			'_apellido' => $this->_apellido,
			'_legajo' => $this->_legajo,
			'_id' => $this->_id,
			'_foto' => $this->_foto,
		];
	}
	public static function listarBDTABLA() {
		$lista = array();           
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
			try {
				$sql = $objetoAccesoDato->retornarConsulta("SELECT * FROM alumnos");
				if ($sql->execute()) {
					while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
						$alumno = new AlumnoBD(
							$data->nombre,
							$data->apellido,
							$data->legajo,
							$data->foto
						);
						$id=-1;
						$alumnos = AlumnoBD::listarBD();
						foreach($alumnos as $alumno)
						{
							if($alumno->_legajo == $data->legajo)
							{
								$id = $alumno->_id;
								break;
							}
						}	
						$alumno->_id=$id;
						$lista[] = $alumno->toArray();
					}
				} else {
					echo "Error en la ejecución de la consulta";
				}
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
    	return $lista;
	}


	public static function listarBD(){		
		$alumnos = array();
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		
        $consulta =$objetoAccesoDato->retornarConsulta("SELECT * FROM  alumnos");
        $consulta->execute();

        while($fila = $consulta->fetch())
        {
          $item= new AlumnoBD($fila[3], $fila[2], $fila[1], $fila[4]); 
		  $item->_id=$fila[0];   
          array_push($alumnos, $item);
        }

		return $alumnos;         		
	}

    public static function generarTablaBD($array)
    {
        echo "<div>
        <table border=1>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>LEGAJO</td>
                    <td>APELLIDO</td> 
                    <td>NOMBRE</td>
                    <td>IMAGEN</td>
                </tr>
            </thead>"; 
        foreach($array as $alumno)
        {
            echo "<tr>";
                echo "<td>" . $alumno->_id . "</td>";
                echo "<td>" . $alumno->_legajo . "</td>";
                echo "<td>" . $alumno->_apellido . "</td>";
                echo "<td>" . $alumno->_nombre . "</td>";
                echo "<td>";
                if($alumno->_foto != "")
                {
                    if(file_exists("./fotosBD/".$alumno->_foto)) {
                        echo '<img src="./fotosBD/'.$alumno->_foto.'" alt=./fotosBD/"'.$alumno->_foto . '" height="100px" width="100px">'; 
                    }else{
                        echo 'No hay imagen guardada en '. $alumno->_foto; 
                    }
                }else{
                    echo "Sin datos //";
                }
                echo "</td>";
            echo "</tr>";
        }
        echo "</table>
        </div>";
    }

	public static function decodeAlumno($alumno){
      $obj_alumno = json_decode($alumno);
      $addAlumno = new AlumnoBD($obj_alumno->_nombre,$obj_alumno->_apellido,$obj_alumno->_legajo,$obj_alumno->_foto);
      $addAlumno->_id = $obj_alumno->_id;
      return $addAlumno;
    }
}