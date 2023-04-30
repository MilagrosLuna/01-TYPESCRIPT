/*2. Cree una aplicación que muestre, a través de un Array, los nombres de los meses de un
año y el número al que ese mes corresponde. Utilizar una estructura repetitiva para
escribir en la consola (console.log()).*/


let meses : Array<string> = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
let numeros : Array<number> = [1,2,3,4,5,6,7,8,9,10,11,12];

for(let i :number = 0 ; i<12 ; i++)
{
    console.log(`El numero de mes es ${numeros[i]} y su nombre ${meses[i]}`);
}