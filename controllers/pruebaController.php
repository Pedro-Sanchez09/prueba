<?php

require_once("../models/Prueba.php");

$prueba = new Prueba();

switch ($_GET["op"]) {

    case 'query':
        $asignarToken = $prueba->setToken();
        if ($asignarToken) {
            $datos = $prueba->getDatosPrueba();
            echo json_encode($d);
        } else {
            echo json_encode(array('status' => 400, 'message' => 'Error'));
        }
        break;

    default:
}
