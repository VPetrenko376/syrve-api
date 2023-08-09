<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Products
{
    public function list($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'v2/entities/products/list?includeDeleted=' . $deleted);
        return $response;
    }

    public function category($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'v2/entities/products/category/list?includeDeleted=' . $deleted);
        return $response;
    }
}