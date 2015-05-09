<?php
    function Invia($mes){
    $APPLICATION_ID = "ULStKyRztObJoXG8xlNS1rLPolbl3x0xyIIdUjQb";
    $REST_API_KEY = "i4ADezCZUDAns21ADfZ9a3H2nF1Jhwu29jNbgCFD";
    $MESSAGE = $mes;
    
    if (!empty($mes)) {
        
        $errors = array();
        foreach (array('app' => $APPLICATION_ID, 'api' => $REST_API_KEY, 'body' => $MESSAGE) as $key => $var) {
            if (empty($REST_API_KEY)) {
                $errors[$var] = true;
            } else {
                $$var = $REST_API_KEY;
            }
        }
        
        if (!$errors) {
            $url = 'https://api.parse.com/1/push';
            $data = array(
                          'channel' => 'motocross',
                          'type' => 'ios',
                          'expiry' => 1451606400,
                          'data' => array(
                                          'alert' => $MESSAGE,
                                           'badge' => '1',
                                           'sound' => '',
                                          ),
                          );
            $_data = json_encode($data);
            $data1=array(
                          'channel' => 'prova',
                          'type' => 'ios',
                          'expiry' => 1451606400,
                          'data' => array(
                                          'alert' => $MESSAGE,
                                           'badge' => '1',
                                           'sound' => '',
                                          ),
                          );
            $_data1 = json_encode($data1);
			$temp=array($_data,$_data1);
			for($i=0;$i<count($temp);$i++){
            $headers = array(
                             'X-Parse-Application-Id: ' . $APPLICATION_ID,
                             'X-Parse-REST-API-Key: ' . $REST_API_KEY,
                             'Content-Type: application/json',
                             'Content-Length: ' . strlen($temp[$i]),
                             );
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $temp[$i]);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
			}
        }
    }
    }

function Invia2($mes){
    $APPLICATION_ID = "u0IDclD6sLyxahnKWxd5zjhWX8fHWBo4yGOYToiD";
    $REST_API_KEY = "53zrPwyEYqJcfuaF6MHkIk02JwP6SttUE8EQTJdX";
    $MESSAGE = $mes;
    
    if (!empty($mes)) {
        
        $errors = array();
        foreach (array('app' => $APPLICATION_ID, 'api' => $REST_API_KEY, 'body' => $MESSAGE) as $key => $var) {
            if (empty($REST_API_KEY)) {
                $errors[$var] = true;
            } else {
                $$var = $REST_API_KEY;
            }
        }
        
        if (!$errors) {
            $url = 'https://api.parse.com/1/push';
            $data = array(
                          'channel' => 'motocrossFree',
                          'type' => 'ios',
                          'expiry' => 1451606400,
                          'data' => array(
                                          'alert' => $MESSAGE,
                                           'badge' => '1',
                                           'sound' => 'moto.wav',
                                          ),
                          );
            $_data = json_encode($data);
            $headers = array(
                             'X-Parse-Application-Id: ' . $APPLICATION_ID,
                             'X-Parse-REST-API-Key: ' . $REST_API_KEY,
                             'Content-Type: application/json',
                             'Content-Length: ' . strlen($_data),
                             );
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
        }
    }
    }
    ?>