<?php

function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

if(isLocalhost()){
    define("DB_HOST", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_DATABASE_NAME", "leaddesk");
} else {
   /*----------------{ can enter desired DB HOST details }----------------*/
}



/*----------------{ URI define }----------------*/
$uri_controller = 3;
$uri_action = 4;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
define("APIURL", "/api/");

/*----------------{ Table name define }----------------*/
define("ATTENDANCE_TABLE", "attendance");
define("USERS_TABLE", "usercredentials");
define("COMPANY_TABLE", "company");
define("DEPARTMENT_TABLE", "department");
define("LEAVE_TABLE", "leaveapplication");
define("TASK_TABLE", "task");




define("USER_ROLE_ADMIN", 0);
define("USER_ROLE_EMPLOYEE", 1);
define("ADMINEMAIL", "noreply@theleaddesk.com");


// STATUS
define("STATUS_TODO", 1);
define("STATUS_INPROGRESS", 2);
define("STATUS_PAUSE", 3);
define("STATUS_COMPLETED", 4);
define("STATUS_DONE", 5);
define("STATUS_CANCELLED", 6);

// PRIORITY
define("PRIORITY_NORMAL", 1);
define("PRIORITY_HIGH", 2);
define("PRIORITY_LOW", 3);

//LEAVE
define("CASUAL_LEAVE", 1);
define("SICK_LEAVE", 2);

// Images Path
define("ASSETS_ROOT_PATH", "assets/uploads/");


function numberFormatter($val){
    return number_format($val, 0, '.', ',');
}

require PROJECT_ROOT_PATH . "/vendor/autoload.php";

function getProtocol() {
    return
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
}

function getHost() {
    return getProtocol(). $_SERVER['HTTP_HOST'];
}

?>