<?php

class CompanyController extends BaseController
{    
    function CreateCompany()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $companyModel = new CompanyModel();

                $result = $companyModel->AddCompany($PortalUserId,$CompanyName,$Address,$PhoneNumber);
                if($result){
                    $responseData = json_encode(array('success' => true, 'message' => 'Company Created Successfully','companyId'=>$result));
                }else{
                    $responseData = json_encode(array('success' => false, 'message' => 'Company Name Already Exist!'));
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

    function UpdateCompany()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $companyModel = new CompanyModel();

                $result = $companyModel->EditCompany($Id,$CompanyName,$Address,$PhoneNumber);
                if($result===false){
                    $responseData = json_encode(array('success' => true, 'message' => 'Company Updated Successfully'));
                }else{
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

    public function delete()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        /* POST Method */
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $companyModel = new CompanyModel();
                extract($_POST);
                $arrDepartment = $companyModel->deleteCompany($id);
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
