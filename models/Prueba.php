
<?php
/**
 * Clase Prueba
 * @author Pedro Luis Sanchez Calle (psanchezc09@gmail.com - pedroluissanchezcalle7@gmail.com)
 * @version v.1.0.0
 */
class Prueba
{
    /**
     * Guarda la url para iniciar la petición al web service.
     * @access private 
     */
    private $getChallange;
    /**
     * @access private
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
     * Asigna un valor a la variable $token
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
     * Crea la AccesKey del usuario prueba
     * @return $AccessKey del usuario prueba
     */
    function getAccessKey(): string
    {
        try {
            $this->token = $this->token;
            $claveAcceso = '3DlKwKDMqPsiiK0B';
            $AccessKey = md5($this->token . $claveAcceso);
            return $AccessKey;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Obtiene la sessionName del usuario
     * @return string $sessionName
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
     * Obtiene los datos del web service
     * @return [] de datos 
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


    /**
     * Devuelve el número total de Contactos del web service.
     */
    function getTotal()
    {
        try {
            $sessionName = $this->getSessionName();
            $url = "https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php?operation=query&sessionName=$sessionName&query=select count(*) from Contacts;";
            $url = str_replace(' ', '%20', $url);
            $resultado = json_decode(file_get_contents($url), true);
            return array("status" => 200, "data" => $resultado['result']);
        } catch (Exception $e) {
            return $e;
        }
    }
}
?>