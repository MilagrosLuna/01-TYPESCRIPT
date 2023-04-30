namespace Ajax
{
  export function Agregar():void
  {        
    let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
    xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
    let form : FormData = new FormData();
    let nombre = <HTMLInputElement>document.getElementById("_nombreA");
    let apellido = <HTMLInputElement>document.getElementById("_apellidoA");
    let legajo = <HTMLInputElement>document.getElementById("_legajoA");
    let archivo : any =  document.getElementById("archivoA");

    form.append("_accion", "agregar");
    form.append("_nombre", nombre.value);
    form.append("_apellido", apellido.value);
    form.append("_legajo", legajo.value);
    form.append("archivo", archivo.files[0]);
    
    xmlhttp.send(form);

    xmlhttp.onreadystatechange = function() 
    {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
      {
        alert(xmlhttp.responseText);        
      }
    }    
  }

  export function Modificar():void
  {        
    let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
    xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
    let form : FormData = new FormData();
    let nombre = <HTMLInputElement>document.getElementById("_nombreM");
    let apellido = <HTMLInputElement>document.getElementById("_apellidoM");
    let legajo = <HTMLInputElement>document.getElementById("_legajoM");
    let archivo : any =  document.getElementById("archivoM");

    form.append("_accion", "modificar");
    form.append("_nombre", nombre.value);
    form.append("_apellido", apellido.value);
    form.append("_legajo", legajo.value);
    form.append("archivo", archivo.files[0]);
    
    xmlhttp.send(form);

    xmlhttp.onreadystatechange = function() 
    {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
      {
        alert(xmlhttp.responseText);        
      }
    }    
  }
  export function Borrar():void
  {        
    let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
    xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
    let form : FormData = new FormData();
    let legajo = <HTMLInputElement>document.getElementById("_legajoB");

    form.append("_accion", "borrar");
    form.append("_legajo", legajo.value);
    
    xmlhttp.send(form);

    xmlhttp.onreadystatechange = function() 
    {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
      {
        alert(xmlhttp.responseText);        
      }
    }    
  }
  export function Listar():void
  {
    let xmlhttp : XMLHttpRequest = new XMLHttpRequest();
    xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
    let form : FormData = new FormData();

    form.append("_accion", "listarpost");
    
    xmlhttp.setRequestHeader("enctype", "multipart/form-data");
    xmlhttp.send(form);

    xmlhttp.onreadystatechange = function() 
    {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
      {        
        alert(xmlhttp.responseText);   
        try {
          var response = JSON.parse(xmlhttp.responseText);
          console.log(response); // Verifica si la respuesta es correcta
          // Crea la tabla
        } catch(e) {
          console.error(e); // Maneja cualquier excepción que se produzca al analizar la respuesta JSON
        }

        let array :any  = JSON.parse(xmlhttp.responseText);
        let tabla: string = "<table border=1 style='width:100%' text-aling='center'> <thead>";
        tabla += "<thead>";
        tabla += "<tr>";
        tabla += "<td>ID</td>";
        tabla += "<td>LEGAJO</td>";
        tabla += "<td>APELLIDO</td>";
        tabla += "<td>NOMBRE</td>";
        tabla += "<td>IMAGEN</td>";
        tabla += " </tr>";
        tabla += "</thead>";
        for(let i =0; i<array.length;i++)
        {
           // mostrará toda la información de cada uno de los televisores
           tabla += "<tr>";
           tabla += "<td>" + array[i]._id + "</td>";
           tabla += "<td>" + array[i]._legajo + "</td>";
           tabla += "<td>" + array[i]._apellido + "</td>";
           tabla += "<td>" + array[i]._nombre + "</td>";
           // (incluida la foto)
           tabla += "<td>";
           var img = new Image();
           let path: string = array[i]._foto;
           if (array[i]._foto !== "") {
               img.src = "./backendBD/fotosBD/" + path;
               tabla += "<img src='./backendBD/fotosBD/" + array[i]._foto + "' height=100 width=100 ></img>";
           } else {
               tabla += "No hay foto";
           }
           tabla += "</td>"; 
        }
        tabla += "</table>";   
        (<HTMLInputElement>document.getElementById("divTabla")).innerHTML =tabla;  


      }
    }    
  }

}
