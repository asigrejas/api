<?php

namespace Library;

/**
 * Verifica a latitude e longitude do endereço
 * Rua Arthur Staude, 189 - Uberaba, Curitiba - PR, 81550-190, Brasil.
 */
class GMaps
{
    private $url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address=';

    private function get($address)
    {
        if (function_exists('curl_init')) {
            $cURL = curl_init($this->url.urlencode($address));
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
            $resultado = curl_exec($cURL);
            curl_close($cURL);
        } else {
            $resultado = file_get_contents($url);
        }
        if (!$resultado) {
            return false;
            //trigger_error('Não foi possível carregar o endereço: <strong>' . $url . '</strong>');
        } else {
            return $resultado;
        }
    }

    public function location($address)
    {
        //return $this->url . urlencode($address);
        $address = $this->get($address);

        if ($address) {
            $address = json_decode($address);
        }

        if ($address && isset($address->results) && isset($address->status) && $address->status == 'OK') {
            return $address->results[0]->geometry->location;
        }

        return 'nada';
    }
}
