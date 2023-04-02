"use strict";
/*12. Crear una función que reciba como único parámetro una cadena que contenga el día, mes
y año de nacimiento de una persona (con formato dd-mm-yyyy). La función mostrará por
consola a que signo corresponde dicha fecha de nacimiento.
Nota: Para descomponer la fecha recibida como parámetro utilice la función split.*/
function QueSigno(cadena) {
    let [diaStr, mesStr, año] = cadena.split('-');
    let dia = parseInt(diaStr);
    let mes = parseInt(mesStr);
    let signo = "";
    if ((mes == 1 && dia <= 20) || (mes == 2 && dia >= 22)) {
        signo = "capricornio";
    }
    else if ((mes == 1 && dia >= 21) || (mes == 2 && dia <= 18)) {
        signo = "Acuario";
    }
    else if ((mes == 2 && dia >= 19) || (mes == 3 && dia <= 20)) {
        signo = "Piscis";
    }
    else if ((mes == 3 && dia >= 21) || (mes == 4 && dia <= 20)) {
        signo = "Aries";
    }
    else if ((mes == 4 && dia >= 21) || (mes == 5 && dia <= 21)) {
        signo = "Tauro";
    }
    else if ((mes == 5 && dia >= 22) || (mes == 6 && dia <= 21)) {
        signo = "Géminis";
    }
    else if ((mes == 6 && dia >= 22) || (mes == 7 && dia <= 22)) {
        signo = "Cáncer";
    }
    else if ((mes == 7 && dia >= 23) || (mes == 8 && dia <= 23)) {
        signo = "Leo";
    }
    else if ((mes == 8 && dia >= 24) || (mes == 9 && dia <= 23)) {
        signo = "Virgo";
    }
    else if ((mes == 9 && dia >= 24) || (mes == 10 && dia <= 23)) {
        signo = "Libra";
    }
    else if ((mes == 10 && dia >= 24) || (mes == 11 && dia <= 22)) {
        signo = "Escorpio";
    }
    else if ((mes == 11 && dia >= 23) || (mes == 12 && dia <= 21)) {
        signo = "Sagitario";
    }
    return signo;
}
console.log(QueSigno("14-06-2004"));
//# sourceMappingURL=ej12.js.map