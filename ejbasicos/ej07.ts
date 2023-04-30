/*7. Se necesita mostrar por consola los primeros 20 números primos. Para ello realizar una
función.
Nota: Utilizar console.log()*/


function primeros20() {
    let numeroPrimo = 2;
    let contadorPrimos = 0;
  
    while (contadorPrimos < 20) {
      if (esPrimo(numeroPrimo)) {
        console.log(numeroPrimo);
        contadorPrimos++;
      }
      numeroPrimo++;
    }
    }
    
    function esPrimo(numero :number) : boolean|undefined{
        let es_primo : boolean = false;
      if(numero)
      {
        if(numero<=1)
        {
            return es_primo;
        }
        for (let i = 2; i <= Math.sqrt(numero); i++) {
            if (numero % i === 0) {
              return false;
            }
          }
          return true;
        
      }
        return undefined;
      
    }
        
primeros20();