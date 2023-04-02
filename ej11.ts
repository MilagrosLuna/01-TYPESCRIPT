/*11. Definir una función que determine si la cadena de texto que se le pasa como parámetro
es un palíndromo, es decir, si se lee de la misma forma desde la izquierda y desde la
derecha. Ejemplo de palíndromo complejo: "La ruta nos aporto otro paso natural".*/

function EsPalindromo(cadena : string)
{
    if (cadena === cadena.split('').reverse().join('')) {
        console.log("la cadena es palíndromo");
      } else{
        console.log("la cadena NO es palíndromo");
      }
}

EsPalindromo("neuxquen");