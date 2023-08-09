<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Entities
{
    public function list($rootType)
    {
        $response = HttpClient::request('GET', 'v2/entities/list?rootType=' . $rootType);
        return $response;
    }
}