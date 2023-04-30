"use strict";
/*3. Realizar una función que reciba un parámetro requerido de tipo numérico y otro opcional
de tipo cadena. Si el segundo parámetro es recibido, se mostrará tantas veces por
consola, como lo indique el primer parámetro. En caso de no recibir el segundo
parámetro, se mostrará el valor inverso del primer parámetro.*/
function FuncionRandom(numero, apellido) {
    if (apellido) {
        for (let i = 1; i <= numero; i++) {
            console.log(apellido);
        }
    }
    else {
        console.log(numero.toString().split("").reverse().join(""));
        if (numero > 0) {
            console.log(`-${numero}`);
        }
        else {
            console.log(`0`);
        }
    }
}
FuncionRandom(3, "juan");
FuncionRandom(3);
FuncionRandom(23);
//# sourceMappingURL=ej03.js.map