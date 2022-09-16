
<?php

class Prueba
{
    /**
     * @acces private
     */
    private $getChallange;
    /**
     * @acces private
     */
    private $token;
    /**
     * Contruct
     */
    function __construct()
    {
        $this->getChallange = "https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php?operation=getchallenge&username=prueba";
    }

    /**
     * @param $getChallange url para solicitar token
     * 
     */
    function setToken(): bool
    {
        try {
            $challange = json_decode(file_get_contents($this->getChallange), true);
            $this->token = $challange['result']['token'];
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
    /**
     * @return $AccessKey del usuario prueba
     */
    function getAccessKey(): string
    {
        try {
            $this->token = $this->getToken($this->getChallange);
            $claveAcceso = '3DlKwKDMqPsiiK0B';
            $AccessKey = md5($this->token . $claveAcceso);
            return $AccessKey;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return string sessionName
     */
    function getSessionName()
    {
        try {
            $url = "https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php";
            $datos = [
                "operation" => "login",
                "username" => "prueba",
                "accessKey" => $this->getAccessKey($this->token)
            ];
            $opciones = array(
                "http" => array(
                    "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                    "method" => "POST",
                    "content" => http_build_query($datos),
                ),
            );
            $contexto = stream_context_create($opciones);
            $resultado = json_decode(file_get_contents($url, false, $contexto), true);
            return $resultado['result']['sessionName'];
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * @return [] de datos de la petición 
     */

    function getDatosPrueba()
    {
        try {
            $sessionName = $this->getSessionName();
            $url = "https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php?operation=query&sessionName=$sessionName&query=select * from Contacts;";
            $url = str_replace(' ', '%20', $url);
            $resultado = json_decode(file_get_contents($url), true);
            return array("status" => 200, "data" => $resultado['result']);
        } catch (Exception $e) {
            return $e;
        }
    }
}
?>