<?php 

class BaseModel
{
    public function InternalServerError()
    {
        header("HTTP/1.1 500 Internal Server Error");
        exit();
    }

    public function NotFound()
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    public function UnprocessableEntity()
    {
        header("HTTP/1.1 422 Unprocessable Entity");
        exit();
    }

}
?>