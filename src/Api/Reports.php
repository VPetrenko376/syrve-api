<?php

namespace Sloth\SyrveApi\Api;

use DateTime;
use Sloth\SyrveApi\HttpClient;

class Reports
{
    public function olap($reportType, $fromDate, $toDate, $groupByRowFields, $aggregateFields, $accountName = null, $jurPerson = null, $buildSummary = false)
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
            ]
        ];

        if ($accountName) {
            $filters['Account.Name'] = [
                'filterType' => 'IncludeValues',
                'values' => $accountName
            ];
        }

        if ($jurPerson) {
            $filters['Department.JurPerson'] = [
                'filterType' => 'IncludeValues',
                'values' => $jurPerson
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

    public function sales(array $options): array
    {
        $url = 'v2/reports/olap';

        $groupByRowFields = [
            'Department.Id',
            'Department',
            'OpenTime',
            'CloseTime',
            'OrderNum',
            'DishName'
        ];

        $aggregateFields = [
            'DishAmountInt',
            'DishDiscountSumInt'
        ];

        $filters = [
            'OpenDate.Typed' => [
                'filterType' => 'DateRange',
                'periodType' => 'CUSTOM',
                'from' => $options['fromDate'],
                'to' => $options['toDate']
            ],
            'Department.Id' => [
                'filterType' => 'IncludeValues',
                'values' => $options['departments'] ?? []
            ],
            'DeletedWithWriteoff' => [
                'filterType' => 'IncludeValues',
                'values' => ['NOT_DELETED']
            ],
            'OrderDeleted' => [
                'filterType' => 'IncludeValues',
                'values' => ['NOT_DELETED']
            ]
        ];

        $jsonData = [
            'reportType' => 'SALES',
            'buildSummary' => $options['buildSummary'] ?? false,
            'groupByRowFields' => $options['groupByRowFields'] ?? $groupByRowFields,
            'aggregateFields' => $options['aggregateFields'] ?? $aggregateFields,
            'filters' => $options['filters'] ?? $filters
        ];

        $httpOptions = [
            'json' => $jsonData,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ];

        $response = HttpClient::request('POST', $url, $httpOptions);

        return $response;
    }

    public function balance($timestamp, $departments = null, $stores = null, $products = null)
    {
        $timestamp = (new DateTime($timestamp))->format('Y-m-d\TH:i:s');

        $url = "v2/reports/balance/stores";

        $queryParams = [
            'timestamp' => $timestamp,
            'department' => $departments,
            'store' => $stores,
            'product' => $products,
        ];

        $url .= '?' . http_build_query($queryParams);
        $url = preg_replace('/%5B[0-9]+%5D/simU', '', $url);

        $response = HttpClient::request('GET', $url);

        return $response;
    }

    public function balanceCounteragents($timestamp = null, $accounts = null, $counteragents = null, $departments = null)
    {
        $timestamp = (new DateTime($timestamp))->format('Y-m-d\TH:i:s');

        $url = "v2/reports/balance/counteragents";

        $queryParams = [
            'timestamp' => $timestamp,
            'account' => $accounts,
            'counteragent' => $counteragents,
            'department' => $departments,
        ];

        $url .= '?' . http_build_query($queryParams);
        $url = preg_replace('/%5B[0-9]+%5D/simU', '', $url);

        $response = HttpClient::request('GET', $url);

        return $response;
    }
}
