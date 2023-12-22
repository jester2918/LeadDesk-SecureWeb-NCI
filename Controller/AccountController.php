<?php

class AccountController extends BaseController
{
    public function Login(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $err = array();
                $data = array();
                extract($_POST);
                $accountModel = new AccountModel();
                // Validate username_or_email
                if (empty($phoneNumber)) {
                    $err[] = "Please enter a phoneNumber.";
                }
                // Validate password
                if (empty($password)) {
                    $err[] = "Please enter a password.";
                }

                //Check input errors before inserting in database
                if (count($err) > 0) {
                    $responseData = json_encode(array("success" => false, "message" => $err));
                } else {
                    $loginResult = $accountModel->Get($phoneNumber);
                    if (isset($loginResult["Password"])) {
                        $CompanyId = 0;
                        if (password_verify($password, $loginResult["Password"])) {
                            $data["success"] = true;
                            $data["CompanyId"] = $loginResult["OrganizationId"];
                            $data["UserName"] = $loginResult["LoginID"];
                            $data["PhoneNumber"] = $loginResult["ContactNo"];
                            $data["Email"] = $loginResult["Email"];
                            $data["Gender"] = $loginResult["Gender"];
                            $data["UserFullName"] = $loginResult["FullName"];
                            $data["UserType"] = $loginResult["UserTypeId"] == 0 ? 'admin' : 'employee';
                            $data["Id"] = $loginResult["Id"];
                            $data["token"] = base64_encode(json_encode($loginResult));

                            $responseData = json_encode($data);
                        } else {
                            $responseData = json_encode(array("success" => false, "message" => ["Incorrect Password!"]));
                        }
                    } else {
                        $responseData = json_encode(array("success" => false, "message" => ["Invalid phone number or password"]));
                    }
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
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

    public function Register()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $err = array();
                $accountModel = new AccountModel();

                if (empty($fullName)) {
                    $err[] = "Please enter full name.";
                }
                if (empty($phoneNumber)) {
                    $err[] = "Please enter a phone number.";
                }
                if (empty($email)) {
                    $err[] = "Please enter a username or email.";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $err[] = "Please enter a valid email.";
                } else {
                    $userExists = $accountModel->GetByLoginIDAndType($phoneNumber, USER_ROLE_ADMIN);
                    if (!isset($userExists["success"])) {
                        $err[] = "This mobile number already exists.";
                    }
                }
                // Validate password
                if (empty($password)) {
                    $err[] = "Please enter a password.";
                } elseif (strlen($password) < 6) {
                    $err[] = "Password must have atleast 6 characters.";
                }
                if (count($err) > 0) {
                    $responseData = json_encode(array("success" => false, "message" => $err));
                } else {
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    $accountModel->Save($fullName, $email, $phoneNumber, $pass, $gender, $UserTypeId, $DepartmentId, $companyName);
                    $responseData = json_encode(array("success" => true, "message" => "Account created successfully!"));
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

    function updateEmployee()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $accountModel = new AccountModel();
                $pass = password_hash($password, PASSWORD_DEFAULT);
                $result = $accountModel->editEmployee($Id, $fullName, $email, $phoneNumber, $pass, $gender, $UserTypeId, $DepartmentId,$companyName);
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
    
    public function ChangePassword()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];


        if (strtoupper($requestMethod) == 'POST') {
            try {

                extract($_POST);
                $accountModel = new AccountModel();
                $user = $accountModel->GetByLoginID($UserId);
                if (isset($user) && count($user) > 0) {
                    if (password_verify($oldpassword, $user["Password"])) {
                        $pass = password_hash($confpassword, PASSWORD_DEFAULT);
                        $result = $accountModel->ChangePassword($user['Id'], $pass);
                        $responseData = json_encode(array('success' => true, 'message' => 'Password Updated Successfully'));
                    } else {
                        $responseData = json_encode(array('success' => false, 'message' => 'Incorrect old password!'));
                    }
                } else {
                    $responseData = json_encode(array('success' => false, 'message' => 'Incorrect phone number!'));
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
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
    
    public function CreateToken()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $accountModel = new AccountModel();
                $result = $accountModel->createUserToken($userId, $token);
                if ($result == false) {
                    $responseData = json_encode(array('success' => true, 'message' => 'Token Created Successfully'));
                } else {
                    $responseData = json_encode(array('success' => false, 'message' => 'Failed'));
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
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
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $accountModel = new AccountModel();
                extract($_POST);
                $arrDepartment = $accountModel->deleteEmployee($id);
                $responseData = json_encode(array( "success" => true, "message" => "Employee deleted successfully!"));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
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
