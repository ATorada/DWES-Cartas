<?php


function crearBaraja()
{
    $palos = [
        ["corazones", "cor"],
        ["picas", "pic"],
        ["rombos", "rom"],
        ["treboles", "tre"]
    ];

    for ($i = 0; $i < count($palos); $i++) {
        for ($j = 1; $j <= 13; $j++) {
            switch ($j) {
                case 11:
                    $cartas[] = ["palo" => $palos[$i][0], "valor" => "j", "imagen" => $palos[$i][1] . "_j.png"];
                    break;
                case 12:
                    $cartas[] = ["palo" => $palos[$i][0], "valor" => "k", "imagen" => $palos[$i][1] . "_k.png"];
                    break;
                case 13:
                    $cartas[] = ["palo" => $palos[$i][0], "valor" => "q", "imagen" => $palos[$i][1] . "_q.png"];
                    break;
                default:
                    $cartas[] = ["palo" => $palos[$i][0], "valor" => $j, "imagen" => $palos[$i][1] . "_" . $j . ".png"];
                    break;
            }
        }
    }

    return $cartas;
}



function repartir($jugadores, $cantidadCartas, $cartas)
{
    shuffle($cartas);
    $cartasRepartidas = [];
    
    for ($i = 0; $i < $cantidadCartas; $i++) {
        for ($j=0; $j < count($jugadores); $j++) {
            if (!isset($cartasRepartidas[$j]["nombre"])) {
                $cartasRepartidas[$j]["nombre"] = $jugadores[$j];
            }
            [$cartasRepartidas[$j], $cartas] = repartir_una($cartasRepartidas[$j],$cartas);
        }
            
    }
    return [$cartasRepartidas, $cartas];
}


function repartir_una($jugador, $cartas){
    $jugador["mano"][] = array_pop($cartas);
    return [$jugador,$cartas];
}