<?php

class TaskController extends BaseController
{
    public function GetRelatedToMeTasks()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $taskModel = new TaskModel();

                $result = $taskModel->GetRelatedToMeTaskList($userId);

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
    public function GetTasksByCompanyId()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $taskModel = new TaskModel();

                $result = $taskModel->GetTasksByCompanyId($CompanyId);

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
    public function GetTaskStatusList()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $statusList = [
                    array('Id' => STATUS_TODO, 'Name' => 'Todo'),
                    array('Id' => STATUS_INPROGRESS, 'Name' => 'In Progress'),
                    array('Id' => STATUS_PAUSE, 'Name' => 'Pause'),
                    array('Id' => STATUS_COMPLETED, 'Name' => 'Completed'),
                    array('Id' => STATUS_DONE, 'Name' => 'Done'),
                    array('Id' => STATUS_CANCELLED, 'Name' => 'Cancelled')
                ];
                $responseData = json_encode($statusList);
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
    public function GetPriorityList()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $priorityList = [
                    array('Id' => PRIORITY_NORMAL, 'Name' => 'Normal'),
                    array('Id' => PRIORITY_HIGH, 'Name' => 'High'),
                    array('Id' => PRIORITY_LOW, 'Name' => 'Low')
                ];
                $responseData = json_encode($priorityList);
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
    public function UploadDocuments()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        /* POST Method */
        if (strtoupper($requestMethod) == 'POST') {
            extract($_POST);
            try {
                $err = array();
                if (isset($_FILES["thumb"]["name"])) {
                    $thumb = trim($_FILES["thumb"]["name"]);
                    $path = __DIR__ . '/../' . ASSETS_ROOT_PATH . '' . $thumb;
                    $file = $_FILES["thumb"]["tmp_name"];
                    if (!move_uploaded_file($file, $path)) {
                        $err[] = "Image upload failed";
                    }
                }
                if (count($err) > 0) {
                    $responseData = json_encode(array("success" => false, "message" => $err));
                } else {
                    $responseData = json_encode(array("success" => true, "message" => "Image Uploaded successfully!", "image" => $_FILES["thumb"]["name"]));
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
    public function SaveTask()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        /* POST Method */
        if (strtoupper($requestMethod) == 'POST') {
            extract($_POST);
            try {
                $err = array();
                $taskModel = new TaskModel();

                if (empty($StatusId)) {
                    $StatusId = STATUS_TODO;
                }
                if (empty($PriorityId)) {
                    $PriorityId = PRIORITY_NORMAL;
                }
                if (!isset($Id)) {
                    $Id = 0;
                }
                $result = $taskModel->SaveTask($Id, $StatusId, $PriorityId, $CreatedById, $CompanyId, $AssignedToId, $Title, $Description, $DueDate, $taskAttachmentsModel);
                $responseData = json_encode($result);
                $attachments = json_decode($taskAttachmentsModel);
                if (!empty($result) && $result !== 0 && !empty($attachments)) {
                    foreach ($attachments as $item) {
                        if (!empty($item->BlobName)) {
                            $taskId = $result;
                            $blobName = $item->BlobName;
                            $fileName = $item->FileName;
                            $updatedById = $CreatedById;
                        }
                    }
                }

                if (count($err) > 0) {
                    $responseData = json_encode(array("success" => false, "message" => $err));
                } else{
                    $responseData = json_encode(array("success" => true, "message" => $err));
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
    public function ChangeTaskStatusId()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                extract($_POST);
                $taskModel = new TaskModel();

                $result = $taskModel->ChangeTaskStatusId($taskId,$taskStatusId);
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
    public function DeleteTask()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $taskModel = new TaskModel();

                $result = $taskModel->DeleteTask($taskId);
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
    //Employee
    public function GetAssignedToMeTasks()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                extract($_GET);
                $taskModel = new TaskModel();
                $result = $taskModel->GetTaskListByAsigneeId($userId);
                if(count($result)>0){
                    $responseData = json_encode($result);
                }else{           
                    $responseData = json_encode(array('success' => false,'message'=>'No Tasks Yet!'));
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
