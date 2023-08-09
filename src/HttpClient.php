<?php

namespace Sloth\SyrveApi;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\BadResponseException;

class HttpClient
{
    private static $client;

    public static function init($credentials)
    {
        self::setClient(self::$client ?: new Client(['base_uri' => $credentials['uri'], 'cookies' => true]));
        self::getToken($credentials['login'], sha1($credentials['password']));
    }

    private static function setClient($client)
    {
        self::$client = $client;
    }

    public static function request($method, $path, $options = [])
    {
        try {
            $response = self::$client->request($method, $path, $options)->getBody()->getContents();
            
            if (preg_match('/^\s*<\?xml[^\?]*\?>/', $response)) {
                $response = ApiUtilities::xmlToArray($response);
            } else {
                $response = json_decode($response, true);
            }
            
            return $response;
        }
        catch (BadResponseException  $e) {
            $response = $e->getResponse()->getBody()->getContents();
            return ['error' => $response];
        }
    }

    private static function getToken($login, $password)
    {
        self::request('GET', 'auth?login=' . $login . '&pass=' . $password);
    }
    
    public static function logout()
    {
        self::request('GET', 'logout');
    }
}