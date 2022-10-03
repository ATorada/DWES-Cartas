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

    <?php

        include_once('includes/funciones.inc.php');

        $jugadores = ["Banca","Jugador1","Jugador2","Jugador3","Jugador4","Jugador5",];

        [$cartasRepartidas, $cartas] = repartir($jugadores, 2, $cartas);

        $cartasRepartidas = repartir($jugadores, 2, $cartas);

        foreach ($cartasRepartidas as $jugador => $cartas) {
            echo $jugador.' ';
            echo '<div class="contenedor">';
            $valor = 0;
            foreach ($cartas as $carta) {
                echo '<div class="imagen"><img src="/img/baraja/'.$carta["imagen"].'" alt="'.$carta["palo"].'_'.$carta["valor"].'"></div>';
                $valor += $carta["valor"];
            }
            echo '<h2>'.$jugador.' ha sacado '.$valor.'</h2>';
            echo '</div>';
           echo '<br>';
       }

    ?>
</body>
</html>