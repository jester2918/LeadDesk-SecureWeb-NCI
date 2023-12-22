<?php
require __DIR__ . "/../inc/bootstrap.php";
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$requestMethod = $_SERVER["REQUEST_METHOD"];
if (strtoupper($requestMethod) == 'GET' || strtoupper($requestMethod) == 'POST') {
    if (isset($uri[$uri_controller]) && $uri[$uri_action] != "Login" && $uri[$uri_action] != "Register" && $uri[$uri_action] != "CreateToken") {
        $auth_data = json_decode(AuthCheck());  
        if(!$auth_data->success){
            if(strpos($_SERVER['REQUEST_URI'], APIURL) === false){
                return $auth_data;
            } else {
                $httpHeaders = array('Content-Type: application/json', 'HTTP/1.1 200 OK');
                header_remove('Set-Cookie');
                if (is_array($httpHeaders) && count($httpHeaders)) {
                    foreach ($httpHeaders as $httpHeader) {
                        header($httpHeader);
                    }
                }
                echo json_encode($auth_data);
                exit;
            }
        } 
    }
}


$BaseModel = new BaseModel();
$objFeedController = null;

if (isset($uri[$uri_controller])) {
    switch ($uri[$uri_controller]) {
        case 'user':
            require PROJECT_ROOT_PATH . "/Controller/AccountController.php";
            $objFeedController = new AccountController();
            break;
        case 'company':
            require PROJECT_ROOT_PATH . "/Controller/CompanyController.php";
            $objFeedController = new CompanyController();
            break;
        case 'task':
            require PROJECT_ROOT_PATH . "/Controller/TaskController.php";
            $objFeedController = new TaskController();
            break;
        case 'leave':
            require PROJECT_ROOT_PATH . "/Controller/LeaveController.php";
            $objFeedController = new LeaveController();
            break;
        case 'department':
            require PROJECT_ROOT_PATH . "/Controller/DepartmentController.php";
            $objFeedController = new DepartmentController();
            break;
        default:
            $objFeedController = null;
            break;
    }

    if (isset($uri[$uri_action])) {
        $strMethodName = $uri[$uri_action];
        try {
            $objFeedController->{$strMethodName}();
        } catch (Exception $ex) {
            header('HTTP/1.1 500 Internal Server Error');
            echo $ex->getMessage() . ' Something went wrong! Please contact support.';
            exit;
        }
    } else {
        $BaseModel->NotFound();
    }
} else {
    $BaseModel->NotFound();
}
?>