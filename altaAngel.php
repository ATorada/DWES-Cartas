<?php
require_once('includes/functions.inc.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>Alta Ángel</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>✨ Alta ✨</h1>

    <?php
    include_once('includes/cabecera.inc.php');
    ?>
    
    <main>
        <?php

        //Establece los jugadores y crea la baraja para repartir
        $jugador1 = "Ángel";
        $jugador2 = "Rubén";

        $cartas = crearBaraja();

        [$cartasRepartidas, $cartas] = repartir([$jugador1, $jugador2], 10, $cartas);

        //Se realiza un bucle para comparar la mano de ambos jugadores y obtener sus puntos
        $jugador1Resultado = 0;
        $jugador2Resultado = 0;
        for ($i = 0; $i < count($cartasRepartidas[0]["mano"]); $i++) {
            switch ($cartasRepartidas[0]["mano"][$i]["valor"] <=> $cartasRepartidas[1]["mano"][$i]["valor"]) {
                case '1':
                    $jugador1Resultado++;
                    $cartasRepartidas[0]["mano"][$i]["resultado"] = "ganadora";
                    break;
                case '0':
                    $jugador1Resultado++ && $jugador2Resultado++;
                    $cartasRepartidas[0]["mano"][$i]["resultado"] = "empate";
                    $cartasRepartidas[1]["mano"][$i]["resultado"] = "empate";
                    break;
                case '-1':
                    $jugador2Resultado++;
                    $cartasRepartidas[1]["mano"][$i]["resultado"] = "ganadora";
                    break;
            }
        }

        //Se recorre cada jugador para mostrar sus cartas
        foreach ($cartasRepartidas as $jugador) {
            echo '<div class="contenedorJugador">';
            echo '  <h2>' . $jugador["nombre"] . '</h2>';
            mostrarCartas($jugador);
            echo '</div>';
        }

        //Se muestran los puntos de cada jugador y luego se comparan para obtener un ganador
        echo '<b>' . $jugador1 . '</b>' . ' ha sacado ' . '<b>' . $jugador1Resultado . ' puntos.</b><br>';
        echo '<b>' . $jugador2 . '</b>' . ' ha sacado ' . '<b>' . $jugador2Resultado . ' puntos.</b><br>';
        echo '<br>✨';
        switch ($jugador1Resultado <=> $jugador2Resultado) {
            case '1':
                echo '<b>' . $jugador1 . '</b>' . ' ha ganado.';
                break;
            case '0':
                echo '<b>' . $jugador1 . ' y ' . $jugador2 . '</b> han empatado.';
                break;
            case '-1':
                echo '<b>' . $jugador2 . '</b>' . ' ha ganado.';
                break;
        }
        echo '✨';

        ?>
    </main>
</body>

</html>