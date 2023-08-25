<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;
use DateTime;


class Price {
    public function list($dateFrom, $departmentId)
    {
        $dateFrom = (new DateTime($dateFrom))->format('Y-m-d');
        $response = HttpClient::request('GET', "v2/price?dateFrom={$dateFrom}&departmentId={$departmentId}");
        return $response;
    }
}