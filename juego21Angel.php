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
        require_once('includes/functions.inc.php');

        //Establece los jugadores, la baraja y reparte
        $jugadores = ["Banca", "Jugador1", "Jugador2", "Jugador3", "Jugador4", "Jugador5",];
        $cartas = crearBaraja();
        [$cartasRepartidas, $cartas] = repartir($jugadores, 2, $cartas);


        //Calcula los resultados de cada jugador y los muestra
        $contenedorCreado = false;
        foreach ($cartasRepartidas as $jugador) {

            //Crea un contenedor único para la banca y otro para todos los jugadores
            if (!$contenedorCreado && $jugador["nombre"] !== "Banca") {
                echo '<div class="contenedor">';
                $contenedorCreado = true;
            } elseif ($jugador["nombre"] == "Banca") {
                echo '<div class="contenedor">';
            }

            echo '<div class="contenedorJugador">';

            echo $jugador["nombre"] . ' ';
            echo '<div class="contenedorCartas">';

            //Realiza una primera tanda de cálculo y luego roba el jugador
            $tablaDePuntuaciones[$jugador["nombre"]] = calcularPuntosBlackJack($jugador);

            while ($tablaDePuntuaciones[$jugador["nombre"]] <= 13) {
                [$jugador, $cartas] = repartirUna($jugador, $cartas);
                $tablaDePuntuaciones[$jugador["nombre"]] = calcularPuntosBlackJack($jugador);
            }

            mostrarCartas($jugador);

            echo '</div>';
            if ($jugador["nombre"] !== "Banca") {
                if ($tablaDePuntuaciones[$jugador["nombre"]] <= 21) {
                    switch ($tablaDePuntuaciones[$jugador["nombre"]] <=> $tablaDePuntuaciones["Banca"]) {
                        case '1':
                            echo '<p class="ganadora">¡GANA!</p>';
                            break;
                        case '0':
                            echo '<p class="empate">Empatado</p>';
                            break;
                    }
                } elseif ($tablaDePuntuaciones[$jugador["nombre"]] > 21) {
                    echo '<p class="pierde">Pierde :(</p>';
                }
                echo $tablaDePuntuaciones[$jugador["nombre"]] . " puntos";;
            } else {
                echo $tablaDePuntuaciones[$jugador["nombre"]] . " puntos";;
                echo '</div>';
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';

        ?>
    </main>

</body>

</html>