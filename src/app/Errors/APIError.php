<?php namespace App\Errors;

use Illuminate\Http\Response;

class APIError extends Response
{
    public function __construct($error, array $headers = [])
    {
        $content = array_except($error, 'httpStatusCode');
        parent::__construct($content, $error['httpStatusCode'], $headers);
    }
}