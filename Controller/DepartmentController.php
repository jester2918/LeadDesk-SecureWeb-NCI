<?php

class DepartmentController extends BaseController
{
    public function GetDepartmentByCompanyId()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $DepartmentModel = new DepartmentModel();
                $result = $DepartmentModel->GetDepartmentByCompanyId($companyId);
                $responseData = json_encode($result);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc) {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return json_decode($responseData);
            }
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return array('success' => false, 'message' => $strErrorDesc);
            }
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    function UpdateDepartment()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $DepartmentModel = new DepartmentModel();

                $result = $DepartmentModel->EditDepartment($Id,$pid,$DepartmentName);
                if ($result === false) {
                    $responseData = json_encode(array('success' => true, 'message' => 'Department Updated Successfully'));
                } else {
                    $responseData = json_encode(array('success' => false, 'message' => $result));
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc) {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return json_decode($responseData);
            }
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return array('success' => false, 'message' => $strErrorDesc);
            }
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    function CreateDepartment()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $DepartmentModel = new DepartmentModel();

                $result = $DepartmentModel->AddDepartment($pid,$CompanyId, $DepartmentName);
                if ($result === false) {
                    $responseData = json_encode(array('success' => true, 'message' => 'Department Created Successfully'));
                } else {
                    $responseData = json_encode(array('success' => false, 'message' => 'Department Name Already Exist!'));
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc) {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return json_decode($responseData);
            }
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
                return array('success' => false, 'message' => $strErrorDesc);
            }
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function updatedisplayorder()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        /* POST Method */
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $departmentModel = new DepartmentModel();
                extract($_POST);
                $departmentModel->updateOrder($orderIds);
                $responseData = json_encode(array( "success" => true, "message" => "Product display order updated successfully! "));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            if(strpos($_SERVER['REQUEST_URI'], APIURL) === false){
                return json_decode($responseData);
            }
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            if(strpos($_SERVER['REQUEST_URI'], APIURL) === false){
                return array('success' => false, 'message' => $strErrorDesc);
            }
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function delete()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        /* POST Method */
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $departmentModel = new DepartmentModel();
                extract($_POST);
                $arrDepartment = $departmentModel->deleteDepartment($id);
                $responseData = json_encode(array( "success" => true, "message" => "department deleted successfully!"));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            if(strpos($_SERVER['REQUEST_URI'], APIURL) === false){
                return json_decode($responseData);
            }
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            if(strpos($_SERVER['REQUEST_URI'], APIURL) === false){
                return array('success' => false, 'message' => $strErrorDesc);
            }
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}

