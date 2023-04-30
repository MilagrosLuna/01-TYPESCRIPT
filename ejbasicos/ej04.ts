/* 4. Realizar una función que reciba un número y que muestre (por consola) un mensaje
como el siguiente:
El número 5 es impar, siendo 5 el número recibido como parámetro.*/

function FuncionRandom2(numero:number ):void {

    if(numero){
       if(numero%2===0)
       {
            console.log(`El número ${numero} es par, siendo ${numero} el número recibido como parámetro.`);
       }
       else
       {
        console.log(`El número ${numero} es impar, siendo ${numero} el número recibido como parámetro.`);
       }
    }
    else{
        console.log("no valido");
    }
}

FuncionRandom2(5);