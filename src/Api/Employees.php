<?php

namespace Sloth\SyrveApi\Api;

use DateTime;
use Sloth\SyrveApi\ApiUtilities;
use Sloth\SyrveApi\HttpClient;

class Employees
{
    public function list($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'employees?includeDeleted=' . $deleted);
        return $response;
    }

    public function department($departmentCode, $deleted = 'false')
    {
        $response = HttpClient::request('GET', 'employees/byDepartment/' . $departmentCode . '?includeDeleted=' . $deleted);
        return $response;
    }

    public function id($employeeId)
    {
        $response = HttpClient::request('GET', 'employees/byId/' . $employeeId);
        return $response;
    }

    public function code($employeeCode)
    {
        $response = HttpClient::request('GET', 'employees/byCode/' . $employeeCode);
        return $response;
    }

    public function search($params, $deleted = 'false')
    {
        $concatParams = '';

        foreach ($params as $key => $value) {
            $concatParams .= "&$key={$value}";
        }

        $response = HttpClient::request('GET', 'employees/search?includeDeleted=' . $deleted . $concatParams);        
        return $response;
    }

    public function create($employeeData)
    {
        $defaultValues = [
            'id' => ApiUtilities::generateUuid(),
            'login' => '',
            'pinCode' => ApiUtilities::generatePinCode(),
            'deleted' => 'false',
            'employee' => 'true'
        ];

        if (isset($employeeData['birthday'])) {
            $employeeData['birthday'] = (new DateTime($employeeData['birthday']))->format('Y-m-d\TH:i:sP');
        }
        
        if (isset($employeeData['hireDate'])) {
            $employeeData['hireDate'] = (new DateTime($employeeData['hireDate']))->format('Y-m-d\TH:i:sP');
        }
        
        if (isset($employeeData['fireDate'])) {
            $employeeData['fireDate'] = (new DateTime($employeeData['fireDate']))->format('Y-m-d\TH:i:sP');
        }

        $processedEmployeeData = ApiUtilities::setDefaultValues($defaultValues, $employeeData);
        $xml = ApiUtilities::arrayToXML($processedEmployeeData, 'employee');

        $options = [
            'headers' => ['content-type' => 'application/xml'],
            'body' => $xml
        ];

        $response = HttpClient::request('PUT', 'employees/byId/' . $processedEmployeeData['id'], $options);
                
        if (!isset($response['error']) && isset($processedEmployeeData['pinCode'])) {
            $response['pinCode'] = $processedEmployeeData['pinCode'];
        }

        return $response;
    }

    public function edit($employeeData)
    {
        if (isset($employeeData['birthday'])) {
            $employeeData['birthday'] = (new DateTime($employeeData['birthday']))->format('Y-m-d\TH:i:sP');
        }
        
        if (isset($employeeData['hireDate'])) {
            $employeeData['hireDate'] = (new DateTime($employeeData['hireDate']))->format('Y-m-d\TH:i:sP');
        }
        
        if (isset($employeeData['fireDate'])) {
            $employeeData['fireDate'] = (new DateTime($employeeData['fireDate']))->format('Y-m-d\TH:i:sP');
        }

        $options = [
            'form_params' => $employeeData
        ];

        $response = HttpClient::request('POST', 'employees/byId/' . $employeeData['id'], $options);

        if (!isset($response['error']) && isset($employeeData['pinCode'])) {
            $response['pinCode'] = $employeeData['pinCode'];
        }

        return $response;
    }
    
    public function delete($employeeId)
    {
        $response = HttpClient::request('DELETE', 'employees/byId/' . $employeeId);
        return $response;
    }

    public function roles($deleted = 'false')
    {
        $response = HttpClient::request('GET', 'employees/roles?includeDeleted=' . $deleted);
        return $response;
    }
}