<?php

/**
 * Funciones para el correcto funcionamiento de la aplicación web.
 * 
 * Desarrollado por Ángel Torada.
 * 
 */


/**
 * Crea un array de 52 cartas, cada una con un palo, un valor y una imagen asociada.
 * 
 * @return array Devuelve el array de la baraja.
 */
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

/**
 * Baraja el mazo que se le pasa y luego reparte de uno en uno a cada jugador.
 * 
 * @param array $jugadores Array de los jugadores.
 * @param int $cantidadCartas Cantidad de cartas que tendrá cada jugador.
 * @param array $cartas La baraja a utilizar.
 *    $cartas = [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta. Opcional
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *    ]
 *
 * @return array Devuelve un array con las cartas restantes y un array con cada jugador y sus cartas.
 */
function repartir(array $jugadores, int $cantidadCartas, array $cartas)
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

/**
 * Reparte al jugador la última carta de la baraja.
 * 
 * @param array $jugador Array del jugador, contiene su nombre y su mano.
 *    $jugador = [
 *      'nombre'   => (string) Nombre del jugador. Opcional
 *      'mano'     => [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta. Opcional
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *      ]
 *    ]
 * @param array $cartas La baraja a utilizar.
 *    $cartas = [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta. Opcional
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *    ]
 * @return array Devuelve un array con las cartas restantes y un array con el jugador y su mano.
 */
function repartirUna(array $jugador, array $cartas)
{
    $jugador["mano"][] = array_pop($cartas);
    return [$jugador, $cartas];
}

/**
 * Recorre un array y reemplaza todas las ocurrencias que coincidan con un nuevo valor.
 * 
 * @param mixed $valorABuscar El valor a reemplazar.
 * @param mixed $valorNuevo El nuevo valor.
 * @param array $array El array donde se buscará y reemplazará el valor.
 *    $array = [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta.
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *    ]
 * 
 * @return array Devuelve el array resultante.
 */
function sustituirValor($valorABuscar, $valorNuevo, array $array)
{
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]["valor"] == $valorABuscar) {
            $array[$i]["valor"] = $valorNuevo;
        }
    }
    return $array;
}

/**
 * Calcula los puntos de un jugador en base a las reglas del BlackJack.
 * 
 * @param array $jugador El jugador y su mano.
 *    $jugador = [
 *      'nombre'   => (string) Nombre del jugador. Opcional
 *      'mano'     => [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta.
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *      ]
 *    ]
 * 
 * @return int Devuelve los puntos de ese jugador.
 */
function calcularPuntosBlackJack(array $jugador)
{
    $puntos = 0;

    $jugador = sustituirFigurasBlackJack($jugador);

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

/**
 * Se encarga de reemplazar el valor de las figuras de un jugador para hacerlo numérico.
 * 
 * @param array $jugador El jugador al que se le van a sustituir las figuras.
 *    $jugador = [
 *      'nombre'   => (string) Nombre del jugador. Opcional
 *      'mano'     => [
 *          'palo'      => (string) Palo al que pertenece la carta. Opcional
 *          'valor'     => (string/int) Valor de la carta.
 *          'imagen'    => (string) Imagen asociada a la carta. Opcional
 *      ]
 *    ]
 * @return array Devuelve el jugador con la mano cambiada.
 */
function sustituirFigurasBlackJack(array $jugador)
{
    $jugador["mano"] = sustituirValor("j", 10, $jugador["mano"]);
    $jugador["mano"] = sustituirValor("k", 10, $jugador["mano"]);
    $jugador["mano"] = sustituirValor("q", 10, $jugador["mano"]);
    return $jugador;
}

/**
 * Se encarda de mostrar las cartas de un jugador.
 * 
 * @param array $jugador El jugador al que se le van a mostrar las cartas.
 *    $jugador = [
 *      'nombre'   => (string) Nombre del jugador. Opcional
 *      'mano'     => [
 *          'palo'      => (string) Palo al que pertenece la carta.
 *          'valor'     => (string/int) Valor de la carta.
 *          'imagen'    => (string) Imagen asociada a la carta.
 *      ]
 *    ]
 */
function mostrarCartas(array $jugador)
{
    foreach ($jugador["mano"] as $carta) {

        if (isset($carta["resultado"])) {
            echo '<div class="imagen ' . $carta["resultado"] . '"><img src="/img/baraja/' . $carta["imagen"] . '" alt="' . $carta["palo"] . '_' . $carta["valor"] . '"></div>';
        } else {
            echo '<div class="imagen"><img src="/img/baraja/' . $carta["imagen"] . '" alt="' . $carta["palo"] . '_' . $carta["valor"] . '"></div>';
        }
    }
}
