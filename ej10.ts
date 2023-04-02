/*10. Definir una función que muestre información sobre una cadena de texto que se le pasa
como argumento. A partir de la cadena que se le pasa, la función determina si esa cadena
está formada sólo por mayúsculas, sólo por minúsculas o por una mezcla de ambas.*/

function EnQueEsta(cadena : string)
{
    if (cadena === cadena.toUpperCase()) {
        console.log("La cadena está completamente en mayúsculas");
      } else if (cadena === cadena.toLowerCase()) {
        console.log("La cadena está completamente en minúsculas");
      }
      else{
        console.log("La cadena está en minúsculas y mayúsculas");
      }
}

EnQueEsta("MESSI");
EnQueEsta("MessI");
EnQueEsta("messi");