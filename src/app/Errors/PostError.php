<?php namespace App\Errors;

interface PostError
{
    const POST_NOT_FOUND = [
        'id' => 10100,
        'httpStatusCode' => 404,
        'text' => 'Post Not Found',
    ];

    const POST_CREATION_FAILED = [
        'id' => 10101,
        'httpStatusCode' => 404,
        'text' => 'Post Creation Failed',
    ];
}
