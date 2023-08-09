<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;
use DateTime;

class Documents
{
    public function export($typeInvoice, $fromDate, $toDate, $supplierId = null, $deleted = false)
    {
        $fromDate = (new DateTime($fromDate))->format('Y-m-d');
        $toDate = (new DateTime($toDate))->format('Y-m-d');

        if ($typeInvoice === 'incoming' || $typeInvoice === 'outgoing') {
            $url = "documents/export/{$typeInvoice}Invoice?from={$fromDate}&to={$toDate}";
        } else {
            return ['error' => "The invoice type '{$typeInvoice}' does not exist."];
        }

        if (isset($supplierId)) {
            foreach ($supplierId as $value) {
                $url .= "&supplierId={$value}";
            }
        }

        $response = HttpClient::request('GET', $url);

        if (!isset($response['error']) && !$deleted) {
            $response = array_filter($response, function($value) {
                if ($value['status'] != 'DELETED') {
                    return $value;
                }
            });
        }

        return $response;
    }
}