<?php
require_once "./alumnos.php";
use ManejoDeAlumnos\alumnos;

$_accion = isset($_POST["_accion"]) ? $_POST["_accion"] : "sin accion"; 
$_nombre = isset($_POST["_nombre"]) ? $_POST["_nombre"] : "sin nombre"; 
$_apellido = isset($_POST["_apellido"]) ? $_POST["_apellido"] : "sin apellido"; 
$_legajo = isset($_POST["_legajo"]) ? (int) $_POST["_legajo"] : 0; 

if($_accion == "agregar")
{
    $foto_name = $_FILES['archivo']['name'];
    $foto_tmp_name = $_FILES['archivo']['tmp_name'];
    $foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
    $new_foto_name = $_legajo . '.' . $foto_extension;
    
    $destinoFoto = "./fotos/" . $new_foto_name;
    
    $uploadOk = TRUE;
    //VERIFICO QUE EL ARCHIVO NO EXISTA
    if (file_exists($destinoFoto)) {
        echo "El archivo ya existe. Verifique!!!";
        $uploadOk = FALSE;
    }
    //VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
    if ($_FILES["archivo"]["size"] > 5000000 ) {
        echo "El archivo es demasiado grande. Verifique!!!";
        $uploadOk = FALSE;
    }

    $tipoArchivo = pathinfo($destinoFoto, PATHINFO_EXTENSION);

    //SOLO PERMITO CIERTAS EXTENSIONES
    if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
        && $tipoArchivo != "png") {
        echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
        $uploadOk = FALSE;
    }
}
if($_accion == "modificar")
{
    $foto_name = $_FILES['archivo']['name'];
    $foto_tmp_name = $_FILES['archivo']['tmp_name'];
    $foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
    $new_foto_name = $_legajo . '.' . $foto_extension;
    $destinoFoto = "./fotos/" . $new_foto_name;
     //VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
     if ($_FILES["archivo"]["size"] > 5000000 ) {
        echo "El archivo es demasiado grande. Verifique!!!";
        $uploadOk = FALSE;
    }    
    $tipoArchivo = pathinfo($destinoFoto, PATHINFO_EXTENSION);
    //SOLO PERMITO CIERTAS EXTENSIONES
    if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
        && $tipoArchivo != "png") {
        echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
        $uploadOk = FALSE;
    }
}

//var_dump($_GET);
if($_accion == "listar" || $_accion == "sin accion" )
{
   $_accion = join('',$_GET);// convertir a string  // la accion se recibe en el url   nexo.php?_accion=listar
    //echo $_accion;
}
echo "<br>";

switch($_accion)
{
    case "agregar":
        if($uploadOk)
        {
            $nuevoAlumno = new alumnos($_nombre,$_apellido,$_legajo,$new_foto_name) ;        
            try {
                if(alumnos::agregar($nuevoAlumno)){echo"agregado<br>";}
    
                    if ($uploadOk === FALSE) {
                        echo "<br/>NO SE PUDO SUBIR la foto.";
                    } 
                    else {
                        if (move_uploaded_file($foto_tmp_name, $destinoFoto)) {
                            echo "<br/>LA foto  ". basename( $_FILES["archivo"]["name"]). " ha sido subido exitosamente.";
                        } else {
                            echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                        }
                    }
    
            } catch (Exception $e) {
                echo 'Excepción: ',  $e->getMessage(), "<br>";
            }       
        }else{echo "el archivo debe ser valido para agregar el alumno";}
       
        break;
    case "listar":
        echo alumnos::listar(). "<br>";
        /// como poner una etiqueta html?
        
        break;
    case "verificar":
        if(alumnos::buscarPorLegajo($_legajo)){echo"El alumno con legajo $_legajo SI se encuentra en el listado<br>";}
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "modificar":
        $modificado = new alumnos($_nombre, $_apellido, $_legajo,$new_foto_name);
		if(alumnos::modificar($modificado))
        {
            echo"El alumno con legajo $_legajo SI se ha modificado<br>";
            if (move_uploaded_file($foto_tmp_name, $destinoFoto)) {
                echo "<br/>LA foto  ". basename( $_FILES["archivo"]["name"]). " ha sido subido exitosamente.";
            } else {
                echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
            }
        }
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "borrar":
        if(alumnos::borrar($_legajo)){echo"El alumno con legajo $_legajo SI se ha borrado<br>";}
        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    case "obtener":
        if(alumnos::obtener($_legajo)!== null){var_dump(alumnos::obtener($_legajo));}
        else{echo "EL ALUMNO NO EXISTE| O OCURRIO UN PROBLEMA AL TRAERLO == NULL";}
        break;
    case "redirigir":
        echo "Messi";
        if(alumnos::buscarPorLegajo($_legajo))
        {
            $alumno = alumnos::obtener($_legajo);
           session_start();
          $_SESSION ['redirigir'] = array();
          $_SESSION['redirigir']['_nombre']=$alumno->Nombre();
          $_SESSION['redirigir']['_apellido']=$alumno->Apellido();
          $_SESSION['redirigir']['_legajo']=$alumno->Legajo();
          $_SESSION['redirigir']['_foto']=$alumno->Foto();
          header('Location: ./principal.php');
          
        }

        else{echo"El alumno con legajo $_legajo NO se encuentra en el listado<br>";}
        break;
    default:
    echo "<script>alert('ACCION NO VALIDA');</script>";
    break;
        
}



?>