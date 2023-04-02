"use strict";
/* 5. Guardar su nombre y apellido en dos variables distintas. Dichas variables serán pasadas
como parámetro de la función MostrarNombreApellido, que mostrará el apellido en
mayúscula y el nombre solo con la primera letra en mayúsculas y el resto en minúsculas.
El apellido y el nombre se mostrarán separados por una coma (,).
Nota: Utilizar console.log() */
let miNombre = "milagros";
let miApellido = "luna";
let cadena = miNombre.charAt(0).toUpperCase() + miNombre.slice(1).toLowerCase();
;
console.log(`${miApellido.toUpperCase()}, ${cadena}`);
//# sourceMappingURL=ej05.js.map