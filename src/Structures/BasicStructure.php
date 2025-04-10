<?php

namespace Labi9\Elegan\Structures;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class BasicStructure
{
    public function response(string $statusCode): string
    {
        $structure = str_repeat(config('elegan.space'), 8) . $statusCode . ":" . PHP_EOL;

        if ($statusCode == HttpResponse::HTTP_OK) {
            $structure .= str_repeat(config('elegan.space'), 10) . "content:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 12) . "application/json:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 14) . "schema:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 16) . "type: object" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 16) . "properties:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 18) . "data:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 20) . "type: object" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 20) . "properties:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 22) . "#input:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 24) . "#type: integer" . PHP_EOL;

            return $structure;
        }
        $structure .= str_repeat(config('elegan.space'), 10) . '$ref' . ": '../'" . PHP_EOL;

        return $structure;
    }

    public function createFile(string $fileName, string $structure, string $path): void
    {
        $file = fopen(config('elegan.route_path') . '/' . $path . $fileName, 'w');

        fwrite($file, $structure);
        fclose($file);
    }

    public function body(): string
    {
        $structure = str_repeat(config('elegan.space'), 8) .
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY .
            ":" .
            PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . '$ref' . ": '../'" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "requestBody:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "content:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "application/json:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "type: object" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "properties:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "#input:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "#type: string" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "#required:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "#- input" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "examples:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "#name_example:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "value:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "#input: 'example'" . PHP_EOL;

        return $structure;
    }

    public function info(): string
    {
        $structure = str_repeat(config('elegan.space'), 6) . "tags:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "summary: ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "consumes:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- 'application/json'" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "produces:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- 'application/json'" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "responses:" . PHP_EOL;

        return $structure;
    }
}
