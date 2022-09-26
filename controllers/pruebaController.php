<?php

/**
 * Llama el archivo Prueba.php de models
 */
require_once("../models/Prueba.php");
/**
 * Crea una instancia de la clase Prueba
 */
$prueba = new Prueba();
/**
 * Recibe las opciones que mediante petición GET se desea realizar desde la vista
 */
switch ($_GET["op"]) {
        /**
     * Realiza query al web service
     */
    case 'query':
        $asignarToken = $prueba->setToken();
        if ($asignarToken) {
            $datos = $prueba->getDatosPrueba();
            echo json_encode($datos);
        } else {
            echo json_encode(array('status' => 400, 'message' => 'Error'));
        }
        break;
        /**
         * Obtiene el total de contactos del web service.
         */
    case 'total':
        $asignarToken = $prueba->setToken();
        if ($asignarToken) {
            $datos = $prueba->getTotal();
            echo json_encode($datos);
        } else {
            echo json_encode(array('status' => 400, 'message' => 'Error'));
        }
        break;



    default:
}
