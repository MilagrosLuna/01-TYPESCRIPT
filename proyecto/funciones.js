"use strict";
var Ajax;
(function (Ajax) {
    function Agregar() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
        var form = new FormData();
        var nombre = document.getElementById("_nombreA");
        var apellido = document.getElementById("_apellidoA");
        var legajo = document.getElementById("_legajoA");
        var archivo = document.getElementById("archivoA");
        form.append("_accion", "agregar");
        form.append("_nombre", nombre.value);
        form.append("_apellido", apellido.value);
        form.append("_legajo", legajo.value);
        form.append("archivo", archivo.files[0]);
        xmlhttp.send(form);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert(xmlhttp.responseText);
            }
        };
    }
    Ajax.Agregar = Agregar;
    function Modificar() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
        var form = new FormData();
        var nombre = document.getElementById("_nombreM");
        var apellido = document.getElementById("_apellidoM");
        var legajo = document.getElementById("_legajoM");
        var archivo = document.getElementById("archivoM");
        form.append("_accion", "modificar");
        form.append("_nombre", nombre.value);
        form.append("_apellido", apellido.value);
        form.append("_legajo", legajo.value);
        form.append("archivo", archivo.files[0]);
        xmlhttp.send(form);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert(xmlhttp.responseText);
            }
        };
    }
    Ajax.Modificar = Modificar;
    function Borrar() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
        var form = new FormData();
        var legajo = document.getElementById("_legajoB");
        form.append("_accion", "borrar");
        form.append("_legajo", legajo.value);
        xmlhttp.send(form);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert(xmlhttp.responseText);
            }
        };
    }
    Ajax.Borrar = Borrar;
    function Listar() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "./backendBD/nexo_PDO.php", true);
        var form = new FormData();
        form.append("_accion", "listarpost");
        xmlhttp.setRequestHeader("enctype", "multipart/form-data");
        xmlhttp.send(form);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert(xmlhttp.responseText);
                try {
                    var response = JSON.parse(xmlhttp.responseText);
                    console.log(response);
                }
                catch (e) {
                    console.error(e);
                }
                var array = JSON.parse(xmlhttp.responseText);
                var tabla = "<table border=1 style='width:100%' text-aling='center'> <thead>";
                tabla += "<thead>";
                tabla += "<tr>";
                tabla += "<td>ID</td>";
                tabla += "<td>LEGAJO</td>";
                tabla += "<td>APELLIDO</td>";
                tabla += "<td>NOMBRE</td>";
                tabla += "<td>IMAGEN</td>";
                tabla += " </tr>";
                tabla += "</thead>";
                for (var i = 0; i < array.length; i++) {
                    tabla += "<tr>";
                    tabla += "<td>" + array[i]._id + "</td>";
                    tabla += "<td>" + array[i]._legajo + "</td>";
                    tabla += "<td>" + array[i]._apellido + "</td>";
                    tabla += "<td>" + array[i]._nombre + "</td>";
                    tabla += "<td>";
                    var img = new Image();
                    var path = array[i]._foto;
                    if (array[i]._foto !== "") {
                        img.src = "./backendBD/fotosBD/" + path;
                        tabla += "<img src='./backendBD/fotosBD/" + array[i]._foto + "' height=100 width=100 ></img>";
                    }
                    else {
                        tabla += "No hay foto";
                    }
                    tabla += "</td>";
                }
                tabla += "</table>";
                document.getElementById("divTabla").innerHTML = tabla;
            }
        };
    }
    Ajax.Listar = Listar;
})(Ajax || (Ajax = {}));
//# sourceMappingURL=funciones.js.map