<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\HttpClient;
use DateTime;

class Documents
{
    public function export($typeInvoice, $fromDate, $toDate, $number = null, $supplierId = null, $deleted = false)
    {
        $fromDate = (new DateTime($fromDate))->format('Y-m-d');
        $toDate = (new DateTime($toDate))->format('Y-m-d');
        $byNumber = isset($number) ? '/byNumber' : '';

        if ($typeInvoice === 'incoming' || $typeInvoice === 'outgoing') {
            $url = "documents/export/{$typeInvoice}Invoice{$byNumber}?from={$fromDate}&to={$toDate}";
        } else {
            return ['error' => "The invoice type '{$typeInvoice}' does not exist."];
        }

        if ($byNumber) {
            $url .= "&number={$number}&currentYear=false";
        }

        if (isset($supplierId)) {
            foreach ($supplierId as $value) {
                $url .= "&supplierId={$value}";
            }
        }

        $response = HttpClient::request('GET', $url);

        if (!isset($response['error']) && !$deleted && !$byNumber) {
            $response = array_filter($response, function($value) {
                if ($value['status'] != 'DELETED') {
                    return $value;
                }
            });
        }

        return $response;
    }
}