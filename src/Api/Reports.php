<?php

namespace Sloth\SyrveApi\Api;

use DateTime;
use Sloth\SyrveApi\HttpClient;

class Reports
{
    public function olap($reportType, $fromDate, $toDate, $groupByRowFields, $aggregateFields, $accountType = null, $buildSummary = false)
    {
        $fromDate = (new DateTime($fromDate))->format('Y-m-d');
        $toDate = (new DateTime($toDate))->format('Y-m-d');

        $url = 'v2/reports/olap';

        $filters = [
            'DateTime.Typed' => [
                'filterType' => 'DateRange',
                'periodType' => 'CUSTOM',
                'from' => $fromDate . 'T00:00:00',
                'to' => $toDate . 'T23:59:59'
            ],
            "TransactionSide" => [
                "filterType" => "IncludeValues",
                "values" => ["CREDIT"]
            ]   
        ];

        if ($accountType) {
            $filters['Account.Type'] = [
                'filterType' => 'IncludeValues',
                'values' => $accountType
            ];
        }

        $jsonData = [
            'reportType' => $reportType,
            'buildSummary' => $buildSummary,
            'groupByRowFields' => $groupByRowFields,
            'aggregateFields' => $aggregateFields,
            'filters' => $filters
        ];

        $options = [
            'json' => $jsonData,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ];

        $response = HttpClient::request('POST', $url, $options);

        return $response;
    }

    public function balance($timestamp, $departments = null, $stores = null, $products = null)
    {
        $timestamp = (new DateTime($timestamp))->format('Y-m-d\TH:i:s');

        $url = "v2/reports/balance/stores?&timestamp={$timestamp}";

        if ($departments) {
            foreach ($departments as $value) {
                $url .= "&department={$value}";
            }
        }

        if ($stores) {
            foreach ($stores as $value) {
                $url .= "&store={$value}";
            }
        }

        if ($products) {
            foreach ($products as $value) {
                $url .= "&product={$value}";
            }
        }

        $response = HttpClient::request('GET', $url);

        return $response;
    }
}
