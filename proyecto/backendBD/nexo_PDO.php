<?php
require_once "./accesoDatos.php";
require_once "./alumnoBD.php";
use ManejoDeAlumnos\AccesoDatos;
use ManejoDeAlumnos\AlumnoBD;

$_accion = isset($_POST["_accion"]) ? $_POST["_accion"] : "sin accion"; 
$_nombre = isset($_POST["_nombre"]) ? $_POST["_nombre"] : "sin nombre"; 
$_apellido = isset($_POST["_apellido"]) ? $_POST["_apellido"] : "sin apellido"; 
$_legajo = isset($_POST["_legajo"]) ? (int) $_POST["_legajo"] : 0; 

if($_accion == "agregar"||$_accion == "modificar")
{
    $foto_name = $_FILES['archivo']['name'];
    $foto_tmp_name = $_FILES['archivo']['tmp_name'];
    $foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
    $new_foto_name = $_legajo . '.' . $foto_extension;    
    $destinoFoto = "./fotosBD/" . $new_foto_name;    
    $uploadOk = TRUE;   
    if ($_FILES["archivo"]["size"] > 5000000 ) {
        echo "El archivo es demasiado grande. Verifique!!!";
        $uploadOk = FALSE;
    }
    $tipoArchivo = pathinfo($destinoFoto, PATHINFO_EXTENSION);
    if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
        && $tipoArchivo != "png") {
        echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
        $uploadOk = FALSE;
    }
}

if($_accion == "listar" || $_accion == "sin accion" )
{
   $_accion = join('',$_GET);// convertir a string  // la accion se recibe en el url   nexo.php?_accion=listar
}

switch($_accion)
{
    case "agregar":
// #region AGREGAR
        if($uploadOk)
        {                    
            try {
                $nuevoAlumno = new AlumnoBD($_nombre,$_apellido,$_legajo,$new_foto_name);
                //var_dump($nuevoAlumno);
                if(AlumnoBD::agregarBD($nuevoAlumno))
                {
                    echo"agregado<br>";
                    //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
                    if ($uploadOk === FALSE) {
                        echo "<br/>NO SE PUDO SUBIR la foto.";
                    } 
                    else {
                        //MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
                        if (move_uploaded_file($foto_tmp_name, $destinoFoto)) {
                            echo "<br/>LA foto  ". basename( $_FILES["archivo"]["name"]). " ha sido subido exitosamente.";
                        } else {
                            echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                        }
                    }
                }
                else{
                    echo "Error al agregar al alumno, ya existe";
                } 
            } catch (Exception $e) {
                echo 'Excepción: ',  $e->getMessage(), "<br>";
            }       
        }else{echo "el archivo debe ser valido para agregar el alumno";}
// #endregion    
        break;
    case "listar":
        $alumnos=AlumnoBD::listarBD();
        var_dump($alumnos);
        break;
    case "listarpost":   
        echo json_encode(AlumnoBD::listarBDTABLA());
        break;
    case "verificar":
        if(AlumnoBD::obtenerAlumnoBD($_legajo)!== null){echo"El alumno con legajo $_legajo SI se encuentra en el listado<br>";}
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "modificar":
// #region MODIFICAR
        $modificado = new AlumnoBD($_nombre, $_apellido, $_legajo,$new_foto_name);
        
        if(AlumnoBD::modificarBD($modificado))
        {
            echo"El alumno con legajo $_legajo SI se ha modificado<br>";
            if (move_uploaded_file($foto_tmp_name, $destinoFoto)) {
                echo "<br/>LA foto  ". basename( $_FILES["archivo"]["name"]). " ha sido subido exitosamente.";
            } else {
                echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
            }
        }
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
// #endregion
        break;
    case "borrar":
        if(AlumnoBD::borrarBD($_legajo)){echo"El alumno con legajo $_legajo SI se ha borrado<br>";}
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "obtener":
        if(AlumnoBD::obtenerAlumnoBD($_legajo)!== null){var_dump(AlumnoBD::obtenerAlumnoBD($_legajo));}
        else{echo "EL ALUMNO NO EXISTE | O OCURRIO UN PROBLEMA AL TRAERLO == NULL";}
        break;
    case "redirigir":
        if( AlumnoBD::obtenerAlumnoBD($_legajo)!==null)
        {
            $alumno=AlumnoBD::obtenerAlumnoBD($_legajo);            
            session_start();
            $_SESSION ['redirigir'] = array();
            $_SESSION['redirigir']['tiempo']=time();
            $_SESSION['redirigir']['_nombre']=$alumno->Nombre();
            $_SESSION['redirigir']['_apellido']=$alumno->Apellido();
            $_SESSION['redirigir']['_legajo']=$alumno->Legajo();
            $_SESSION['redirigir']['_foto']=$alumno->Foto();
            header('Location: ./principal.php');          
        }else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "tabla":
        AlumnoBD::generarTablaBD(AlumnoBD::listarBD());
        break;
    default:
    echo "<script>alert('ACCION NO VALIDA');</script>";
    break;
        
}
/**/


?>