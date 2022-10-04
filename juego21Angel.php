<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego 21 Ángel</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Juego 21</h1>
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
    foreach ($cartasRepartidas as $jugador) {
        echo $jugador["nombre"] . ' ';
        echo '<div class="contenedor">';

        //Realiza una primera tanda de cálculo y luego roba el jugador
        $jugador = sustituirFigurasBlackJack($jugador);
        $tablaDePuntuaciones[$jugador["nombre"]] = calcularPuntosBlackJack($jugador);

        while ($tablaDePuntuaciones[$jugador["nombre"]] <= 13) {
            [$jugador, $cartas] = repartirUna($jugador, $cartas);
            $jugador = sustituirFigurasBlackJack($jugador);
            $tablaDePuntuaciones[$jugador["nombre"]] = calcularPuntosBlackJack($jugador);
        }

/*         if (condition) {
            $jugador["resultado"] =  "jugador";
        } */

        mostrarCartas($jugador);

        echo '</div>';
        if ($jugador["nombre"] !== "Banca") {
            if ($tablaDePuntuaciones[$jugador["nombre"]] <= 21) {
                switch ($tablaDePuntuaciones[$jugador["nombre"]] <=> $tablaDePuntuaciones["Banca"]) {
                    case '1':
                        echo '<p>Ha ganado</p>';
                        break;
                    case '0':
                        echo '<p>Ha empatado</p>';
                        break;
                }
            } elseif ($tablaDePuntuaciones[$jugador["nombre"]] > 21) {
                echo '<p>Ha perdido</p>';
            }
        }
        echo '<br>';
    }

    ?>
    </main>

</body>

</html>