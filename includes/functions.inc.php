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
        for ($j = 0; $j < count($jugadores); $j++) {
            if (!isset($cartasRepartidas[$j]["nombre"])) {
                $cartasRepartidas[$j]["nombre"] = $jugadores[$j];
            }
            [$cartasRepartidas[$j], $cartas] = repartirUna($cartasRepartidas[$j], $cartas);
        }
    }
    return [$cartasRepartidas, $cartas];
}


function repartirUna($jugador, $cartas)
{
    $jugador["mano"][] = array_pop($cartas);
    return [$jugador, $cartas];
}


//Comprueba si existe una occurencia en el array y la sustituye
function sustituirValor($valorABuscar, $valorNuevo, $array)
{
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]["valor"] == $valorABuscar) {
            $array[$i]["valor"] = $valorNuevo;
        }
    }
    return $array;
}

function calcularPuntosBlackJack($jugador)
{
    $puntos = 0;

    $asEncontrado = false;
    for ($i = 0; $i < count($jugador["mano"]); $i++) {
        $puntos += $jugador["mano"][$i]["valor"];
        if ($jugador["mano"][$i]["valor"] == 1) {
            $asEncontrado = true;
        }
    }
    if ($asEncontrado && $puntos + 10 <= 21) {
        $puntos += 10;
    }
    return $puntos;
}

function sustituirFigurasBlackJack($jugador)
{
    $jugador["mano"] = sustituirValor("j", 10, $jugador["mano"]);
    $jugador["mano"] = sustituirValor("k", 10, $jugador["mano"]);
    $jugador["mano"] = sustituirValor("q", 10, $jugador["mano"]);
    return $jugador;
}

function mostrarCartas($jugador)
{
    foreach ($jugador["mano"] as $carta) {
        echo '<div class="imagen"><img src="/img/baraja/' . $carta["imagen"] . '" alt="' . $carta["palo"] . '_' . $carta["valor"] . '"></div>';
    }
}
