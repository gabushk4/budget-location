<?php 
    class ApiConnectTimeoutException extends Exception
    {
        public function __construct(string $message = "", int $code = 0)
        {
            parent::__construct($message, $code, null);
        }
    }

    class ApiResponseTimeoutException extends Exception
    {
        public function __construct(string $message = "", int $code = 0)
        {
            parent::__construct($message, $code, null);
        }
    } 

    class ApiUnavailableException extends Exception
    {
        public function __construct(int $code=0){
            $message = "API is unavailable: " . $code;
            parent::__construct($message, $code, null);
        }
    }