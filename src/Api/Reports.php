<?php

namespace Sloth\SyrveApi\Api;

use DateTime;
use Sloth\SyrveApi\HttpClient;

class Reports
{
    public function balance($timestamp, $departments = null, $stores = null, $products = null)
    {
        $timestamp = (new DateTime($timestamp))->format('Y-m-d\TH:i:s');

        $url = "v2/reports/balance/stores?&timestamp={$timestamp}";

        if ($departments) {
            foreach ($departments as $value) {
                $url .= "&department={$value}";
            }
        }

        if ($stores) {
            foreach ($stores as $value) {
                $url .= "&store={$value}";
            }
        }

        if ($products) {
            foreach ($products as $value) {
                $url .= "&product={$value}";
            }
        }

        $response = HttpClient::request('GET', $url);

        return $response;
    }
}