<?php

namespace Sloth\SyrveApi;

use Exception;
use SimpleXMLElement;

class ApiUtilities
{
    private static function arrayToXMLElement($data, &$xml, $itemName)
    {
        foreach ($data as $key => $value) {
            $element = is_numeric($key) ? $itemName : $key;

            if (is_array($value)) {
                if (!is_numeric($key)) {
                    if ($itemName === null) {
                        self::arrayToXMLElement($value, $xml, $element);
                    } else {
                        $subnode = $xml->addChild($element);
                        self::arrayToXMLElement($value, $subnode, $itemName);
                    }
                } else {
                    self::arrayToXMLElement($value, $xml, $itemName);
                }
            } else {
                    $xml->addChild($element, htmlspecialchars($value));
            }
        }
    }

    public static function arrayToXML($data, $rootName, $itemName = null)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><' . $rootName . '></' . $rootName . '>');
        self::arrayToXMLElement($data, $xml, $itemName);
        return $xml->asXML();
    }

    public static function xmlToArray($data)
    {
        if (is_array($data)) {
            $response = $data;
        } else {
            $simpleXml = simplexml_load_string($data);
            $json = json_encode($simpleXml);
            $response = json_decode($json, true);
        }
        return $response;
    }

    public static function setDefaultValues($defaultValues, $data) {
        foreach ($defaultValues as $key => $defaultValue) {
            if (array_key_exists($key, $data)) {
                if ($data[$key] === null) {
                    unset($data[$key]);
                }
            } else {
                $data[$key] = $defaultValue;
            }
        }
        return $data;
    }

    public static function generateUuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function generatePinCode()
    {
        return str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }
}