<?php

class LeaveController extends BaseController
{
    public function GetUserLeaves()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $leaveModel = new LeaveModel();
                $data = $leaveModel->UserLeaves($userId);
                $leaves = [];
                foreach ($data as $key) {
                    $tempData = $key;
                    if (!empty($key['FromDate']) && !empty($key['FromDate'])) {
                        $tempData['leaveInDays'] = date('d', strtotime($key['ToDate']) - strtotime($key['FromDate']))-1;
                    }
                    array_push($leaves, $tempData);
                }
                $responseData = json_encode($leaves);
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
    public function Approved()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $leaveModel = new LeaveModel();
                $leaves = $leaveModel->LeaveApproved($id, $userId);
                if($leaves===false){
                    $responseData = json_encode(array('success' => true, 'message' => 'Company Updated Successfully'));
                }else{
                    $responseData = json_encode(array('success' => false, 'message' => $leaves));
                }
                $responseData = json_encode(array("success" => true, "message" => 'Approved Successfully'));
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
    public function Rejected()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $leaveModel = new LeaveModel();
                $leaveModel->LeaveRejected($id);
                $responseData = json_encode(array("success" => true, "message" => 'Rejected Successfully'));
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
    public function GetLeaveByCompanyId()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $leaveModel = new LeaveModel();
                $responseData =  json_encode($leaveModel->GetLeaveByCompanyId($companyId));
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
    public function GetLeaveTypeList()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $leaveTypeList = [
                    array('Id' => CASUAL_LEAVE, 'Name' => 'Casual'),
                    array('Id' => SICK_LEAVE, 'Name' => 'Sick')
                ];
                $responseData = json_encode($leaveTypeList);
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

    public function CreateLeave()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $leaveModel = new LeaveModel();
                $result = $leaveModel->CreateEmployeeLeave($CompanyId, $UserId, $LeaveApplyFrom, $LeaveApplyTo, $IsHalfDay, $LeaveTypeId, $LeaveReason);
                if($result===false){
                    $responseData = json_encode(array('success' => true, 'message' => 'Leave Applied Sucessfully'));
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
}
