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
    <title>Juego 21 Ángel</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>✨ Juego 21 ✨</h1>

    <?php
    include_once('includes/cabecera.inc.php');
    ?>

    <main>
        <?php
        //Establece los jugadores y la baraja para repartir
        $jugadores = ["Banca", "Jugador1", "Jugador2", "Jugador3", "Jugador4", "Jugador5",];
        $cartas = crearBaraja();
        [$cartasRepartidas, $cartas] = repartir($jugadores, 2, $cartas);


        //Crea un contenedor, calcula los puntos y muestra el resultado de la banca únicamente para separarla de los jugadores.
        echo '<div class="contenedor">';

        $banca = array_shift($cartasRepartidas);

        $puntosBanca = calcularPuntosBlackjack($banca);

        while ($puntosBanca <= 13) {
            $banca["mano"][] = array_pop($cartas);
            $puntosBanca = calcularPuntosBlackjack($banca);
        }

        mostrarResultadosBlackjack($banca, $puntosBanca);

        echo '</div>';

        //Crea un contenedor, calcula los puntos y muestra los resultados de los jugadores restantes.
        echo '<div class="contenedor">';

        foreach ($cartasRepartidas as $jugador) {

            $puntos = calcularPuntosBlackjack($jugador);

            while ($puntos <= 13) {
                $jugador["mano"][] = array_pop($cartas);
                $puntos = calcularPuntosBlackJack($jugador);
            }

            mostrarResultadosBlackjack($jugador, $puntos, $puntosBanca);
        }
        echo '</div>';

        ?>
    </main>

</body>

</html>