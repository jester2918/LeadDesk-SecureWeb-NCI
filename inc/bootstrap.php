<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controller/BaseController.php";

// include the Base model file
require_once PROJECT_ROOT_PATH . "/Model/BaseModel.php";

// include main Auth file
require_once PROJECT_ROOT_PATH . "/inc/functions.php";

// include the Account model file
require_once PROJECT_ROOT_PATH . "/Model/AccountModel.php";

// include the Company model file
require_once PROJECT_ROOT_PATH . "/Model/CompanyModel.php";

// include the Leave model file
require_once PROJECT_ROOT_PATH . "/Model/LeaveModel.php";

// include the Task model file
require_once PROJECT_ROOT_PATH . "/Model/TaskModel.php";

// include the Department model file
require_once PROJECT_ROOT_PATH . "/Model/DepartmentModel.php";
?>