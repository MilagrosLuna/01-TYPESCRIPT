/*9. Realizar una función que solicite (por medio de un parámetro) un número. Si el número
es positivo, se mostrará el factorial de ese número, caso contrario se mostrará el cubo de
dicho número.
Nota: Reutilizar la función que determina el factorial de un número y la que calcula el
cubo de un número.*/
function CalcularFactorial2(numero : number):number
{
    let factorial=1;
    for(let i=1;i<=numero;i++)
    {
        factorial *= i;
    }
    return factorial;
}
function RecibeNumero(numero : number):number
{
    if(numero)
    {
        if(numero>0)
        {
            return CalcularFactorial2(numero);
        }
        else if(numero<0)
        {
            return numero ** 3;
        }
        return 0;
    }
    return 0;
}

console.log( "NUMERO : "+ RecibeNumero(-2));