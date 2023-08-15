<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Products
{
    public function list($deleted = 'false', $types = null)
    {
        $url = "v2/entities/products/list?includeDeleted={$deleted}";

        if (isset($types)) {
            foreach ($types as $value) {
                $url .= "&types={$value}";
            }
        }

        $response = HttpClient::request('GET', $url);
        return $response;
    }

    public function category($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'v2/entities/products/category/list?includeDeleted=' . $deleted);
        return $response;
    }
}