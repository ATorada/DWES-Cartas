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
    <h1>Alta</h1>
    <?php
    include_once('includes/cabecera.inc.php');
    ?>
    <main>
    <?php
    require_once('includes/functions.inc.php');

    //Establece los jugadores, la baraja y reparte
    $jugador1 = "Ángel";
    $jugador2 = "Rubén";

    $cartas = crearBaraja();

    [$cartasRepartidas, $cartas] = repartir([$jugador1, $jugador2], 10, $cartas);

    //Calcula los resultados
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

    //Muestras las cartas de cada jugador
    foreach ($cartasRepartidas as $jugador) {
        echo '<h2>'.$jugador["nombre"].'</h2>';
        echo '<div class="contenedor">';
        mostrarCartas($jugador);
        echo '</div>';
        echo '<br>';
    }

    //Muestra los resultados
    echo $jugador1 . ' ha sacado ' . $jugador1Resultado . ' puntos<br>';
    echo $jugador2 . ' ha sacado ' . $jugador2Resultado . ' puntos<br>';
    switch ($jugador1Resultado <=> $jugador2Resultado) {
        case '1':
            echo $jugador1 . ' ha ganado.<br>';
            break;
        case '0':
            echo $jugador1 . ' y ' . $jugador2 . ' han empatado.<br>';
            break;
        case '-1':
            echo $jugador2 . ' ha ganado.<br>';
            break;
    }

    ?>
    </main>
</body>

</html>