<?php

namespace Sloth\SyrveApi\Api;

use Sloth\SyrveApi\ApiUtilities;
use Sloth\SyrveApi\HttpClient;

class Employees
{
    public function list($deleted = false)
    {
        $response = HttpClient::request('GET', 'employees?includeDeleted=' . $deleted);
        $array = ApiUtilities::xmlToArray($response);
        return $array['employee'];
    }

    public function id($employeeId)
    {
        $response = HttpClient::request('GET', 'employees/byId/' . $employeeId);
        $array = ApiUtilities::xmlToArray($response);
        return $array;
    }

    public function code($employeeCode)
    {
        $response = HttpClient::request('GET', 'employees/byCode/' . $employeeCode);
        $array = ApiUtilities::xmlToArray($response);
        return $array['employee'];
    }

    public function department($departmentCode, $deleted = false)
    {
        $response = HttpClient::request('GET', 'employees/byDepartment/' . $departmentCode . '?includeDeleted=' . $deleted);
        $array = ApiUtilities::xmlToArray($response);
        return $array['employee'];
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
        $processedEmployeeData = ApiUtilities::setDefaultValues($defaultValues, $employeeData);
        $xml = ApiUtilities::arrayToXML($processedEmployeeData, 'employee');

        $options = [
            'headers' => ['content-type' => 'application/xml'],
            'body' => $xml
        ];
        
        $response = HttpClient::request('PUT', 'employees/byId/' . $processedEmployeeData['id'], $options);
        
        $array = ApiUtilities::xmlToArray($response);
        
        if (isset($processedEmployeeData['pinCode'])) {
            $array['pinCode'] = $processedEmployeeData['pinCode'];
        }

        return $array;
    }

    public function editTest($employeeData)
    {
        $apiData  = $this->id($employeeData['id']);
        $defaultValues = [
            'id' => $apiData['id'],
            'code' => $apiData['code'],
            'name' => $apiData['name'],
            'login' => '',
            'departmentCodes' => !empty($apiData['departmentCodes']) ? $apiData['departmentCodes'] : null,
            'responsibilityDepartmentCodes' => !empty($apiData['responsibilityDepartmentCodes']) ? $apiData['responsibilityDepartmentCodes'] : null,
            'deleted' => $apiData['deleted'],
            'employee' => $apiData['employee']
        ];
        $processedEmployeeData = ApiUtilities::setDefaultValues($defaultValues, $employeeData);
        $xml = ApiUtilities::arrayToXML($processedEmployeeData, 'employee');

        $options = [
            'headers' => ['content-type' => 'application/xml'],
            'body' => $xml
        ];

        $response = HttpClient::request('PUT', 'employees/byId/' . $processedEmployeeData['id'], $options);
        // $array = ApiUtilities::xmlToArray($response);
        return $response;
    }

    public function edit($employeeData)
    {
        $options = [
            'form_params' => $employeeData
        ];

        $response = HttpClient::request('POST', 'employees/byId/' . $employeeData['id'], $options);
        $array = ApiUtilities::xmlToArray($response);

        if (!isset($array['error']) && isset($employeeData['pinCode'])) {
            $array['pinCode'] = $employeeData['pinCode'];
        }

        return $array;
    }
    
    public function delete($employeeId)
    {
        $response = HttpClient::request('DELETE', 'employees/byId/' . $employeeId);
        return $response;
    }

    public function roles($deleted = false)
    {
        $response = HttpClient::request('GET', 'employees/roles?includeDeleted=' . $deleted);
        $array = ApiUtilities::xmlToArray($response);
        return $array['role'];
    }
}