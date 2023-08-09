<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;

class Corporation
{
    public function departments()
    {
        $response = HttpClient::request('GET', 'corporation/departments');
        return $response;
    }

    public function stores()
    {
        $response = HttpClient::request('GET', 'corporation/stores');
        return $response;
    }

    public function groups()
    {
        $response = HttpClient::request('GET', 'corporation/groups');
        return $response;
    }

    public function terminals()
    {
        $response = HttpClient::request('GET', 'corporation/terminals');
        return $response;
    }
}