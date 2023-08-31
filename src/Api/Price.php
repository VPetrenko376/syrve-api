<?php

namespace Sloth\SyrveApi\Api;

use DateTime;
use Sloth\SyrveApi\HttpClient;

class Price 
{
    public function list($dateFrom, $departmentId)
    {
        $dateFrom = (new DateTime($dateFrom))->format('Y-m-d');
        $response = HttpClient::request('GET', "v2/price?dateFrom={$dateFrom}&departmentId={$departmentId}");
        return $response;
    }
}