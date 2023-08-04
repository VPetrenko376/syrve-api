<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\ApiUtilities;
use Sloth\SyrveApi\HttpClient;

class Documents
{
    public function export($typeInvoice, $fromDate, $toDate, $supplierId = null)
    {
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
        $array = ApiUtilities::xmlToArray($response);
        return $array['document'];
    }
}