<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Entities
{
    public function list($rootType, $deleted = 'false')
    {
        $response = HttpClient::request('GET', 'v2/entities/list?rootType=' . $rootType . '&includeDeleted=' . $deleted);
        return $response;
    }

    public function priceCategories()
    {
        $response = HttpClient::request('GET', 'v2/entities/priceCategories');
        return $response;
    }
}