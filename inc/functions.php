<?php

function AuthCheck()
{
    if (strpos($_SERVER['REQUEST_URI'], APIURL) === false) {
        return json_encode(array(
            "user" => isset($_SESSION["user"]) ? $_SESSION["user"] : array(),
            "message" => "Authorize Successfull!",
            "success" => true
        ));
    }
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $authHeader_arr = explode(" ", $authHeader);

        if ($authHeader_arr[0] == "Bearer") {

            $token = $authHeader_arr[1];
            $user_data = json_decode(base64_decode($authHeader_arr[1]));

            //print_r($user_data-> id);

            $user = new AccountModel();

            $message_response = array(
                "token" => null,
                "user" => null,
                "message" => "Unauthorize user!",
                "success" => false
            );
            if (isset($user_data->Id)) {
                $getUser =  $user->GetByLoginID($user_data->Id);
                if ($getUser['Id']) {
                    $message_response = array(
                        "token" => $token,
                        "user" => $user_data,
                        "message" => "Authorize Successfull!",
                        "success" => true
                    );
                }
            }
            return json_encode($message_response);
        } else {
            $message_response = array(
                "token" => null,
                "user" => null,
                "success" => false,
                "message" => "Bearer not define!"
            );
            return json_encode($message_response);
        }
    } else {
        $message_response = array(
            "token" => null,
            "user" => null,
            "success" => false,
            "message" => "Not authorize"
        );
        return json_encode($message_response);
    }
}
?>