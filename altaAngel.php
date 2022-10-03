<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Ángel</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Alta</h1>
    <?php
    include_once('includes/cabecera.inc.php');
    ?>

    <?php
    include_once('includes/functions.inc.php');


    $cartas = crearBaraja();

    function alta($cartasRepartidas)
    {
        $jugador1 = 0;
        $jugador2 = 0;
        for ($i=0; $i < count($cartasRepartidas[0]["mano"]); $i++) { 
                switch ($cartasRepartidas[0]["mano"][$i]["valor"] <=> $cartasRepartidas[1]["mano"][$i]["valor"]) {
                    case '1':
                        $jugador1++;
                        break;
                    case '0':
                        $jugador1++ && $jugador2++;
                        break;
                    case '-1':
                        $jugador2++;
                        break;
                }
        }
        return [$jugador1,$jugador2];
    }

    $jugador1 = "Ángel";
    $jugador2 = "Rubén";

    [$cartasRepartidas, $cartas] = repartir([$jugador1, $jugador2], 10, $cartas);

    [$jugador1Resultado,$jugador2Resultado] = alta($cartasRepartidas);

    
    foreach ($cartasRepartidas as $jugador) {
        echo $jugador["nombre"].' ';
        echo '<div class="contenedor">';
        foreach ($jugador["mano"] as $carta) {
            echo '<div class="imagen"><img src="/img/baraja/'.$carta["imagen"].'" alt="'.$carta["palo"].'_'.$carta["valor"].'"></div>';
        }
        echo '</div>';
       echo '<br>';
   }

    echo $jugador1 . ' ha sacado '. $jugador1Resultado . ' puntos<br>';
    echo $jugador2 . ' ha sacado '. $jugador2Resultado . ' puntos<br>';
    /*        
        foreach ($cartas as $carta) {
           foreach ($carta as $dato => $info) {
               echo $dato.' -> '.$info.'<br>';
           }
           echo '<br>';
       } 
       */


         

/*        foreach ($cartasRepartidas as $jugador => $cartas) {
            echo $jugador.' ';
            foreach ($cartas as $carta) {
                foreach ($carta as $dato => $info) {
                    echo $dato.' -> '.$info.'<br>';
                }
            }
           echo '<br>';
       }  */



    ?>

    <div><img src="" alt=""></div>
</body>

</html>