<?php

namespace Jcsfran\Elegan\Structures;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthStructure
{
    public function header(): string
    {
        $structure = str_repeat(config('elegan.space'), 6) . "security:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- bearerAuth: []" . PHP_EOL;

        return $structure;
    }

    public function response(): string
    {
        $statusCode = HttpResponse::HTTP_UNAUTHORIZED;
        $description = HttpResponse::$statusTexts[$statusCode];

        $structure = str_repeat(config('elegan.space'), 8) . $statusCode . ":" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'description: ' . $description . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'content:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . 'application/json:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . 'schema:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . 'type: object' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . 'properties:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . 'message:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . 'type: string' . PHP_EOL;

        return $structure;
    }
}
