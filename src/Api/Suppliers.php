<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Suppliers
{
    public function list($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'suppliers?includeDeleted=' . $deleted);
        return $response;
    }
}