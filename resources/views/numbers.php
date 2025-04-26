<?php
function obtenerNumerosAleatorios() {
    // Crear un array con los números del 1 al 54
    $numeros = range(1, 54);
    
    // Mezclar el array aleatoriamente
    shuffle($numeros);
    
    // Convertir el array en una cadena de texto separada por comas
    return implode(',', $numeros);
}

// Llamar a la función y mostrar el resultado
echo obtenerNumerosAleatorios();

echo "<br>";
function generarListaNumeros() {
    // Inicializar el array
    $numeros = array();

    // Añadir los números especificados
    $numeros = array_merge($numeros, array_fill(0, 5, 300)); // 5 veces 300
    $numeros = array_merge($numeros, array_fill(0, 10, 200)); // 10 veces 200
    $numeros = array_merge($numeros, array_fill(0, 14, 100)); // 14 veces 100
    $numeros = array_merge($numeros, array_fill(0, 25, 50));  // 25 veces 50

    // Calcular cuántos números adicionales se necesitan para llegar a 54
    $cantidadActual = count($numeros);
    $cantidadFaltante = 54 - $cantidadActual;

    // Si es necesario, añadir números aleatorios para completar la lista
    if ($cantidadFaltante > 0) {
        $numerosAleatorios = array_merge(
            array_fill(0, $cantidadFaltante, rand(1, 300))
        );
        $numeros = array_merge($numeros, $numerosAleatorios);
    }
    // Mezclar el array para obtener un orden aleatorio
    shuffle($numeros);
    foreach ($numeros as $numero) {
        if ($numero == 50) {
            echo "$5,";
        } elseif ($numero == 100) {
            echo "$10,";
        } elseif ($numero == 200) {
            echo "$20,";
        } elseif ($numero == 300) {
            echo "$30,";
        } else {
            echo "$numero,";
        }
    }
    echo "<br>";

    foreach ($numeros as $numeron) {
            echo "$".$numeron.",";
    }
    echo "<br>";
    // Convertir el array en una cadena de texto separada por comas
    return implode(',', $numeros);
}

// Llamar a la función y mostrar el resultado
generarListaNumeros();
    $miArray = [];
    $tamano = sizeof($miArray);
echo "El tamaño del array es: $tamano"; // Resultado: El tamaño del array es: 3
?>