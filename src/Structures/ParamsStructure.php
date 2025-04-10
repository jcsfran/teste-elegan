<?php

namespace Jcsfran\Elegan\Structures;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ParamsStructure
{
    public function header(array $params): string
    {
        $structure = str_repeat(config('elegan.space'), 6) . "parameters:" . PHP_EOL;

        foreach ($params as $param) {
            $structure .= str_repeat(config('elegan.space'), 8) . "- in: path" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 10) . 'name: ' . $param . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 10) . "schema:" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 12) . "type: ''" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 10) . "required: true" . PHP_EOL;
            $structure .= str_repeat(config('elegan.space'), 10) . "description: ''" . PHP_EOL;
        }

        return $structure;
    }

    public function response(): string
    {
        $statusCode = HttpResponse::HTTP_NOT_FOUND;
        $description = HttpResponse::$statusTexts[$statusCode];

        $structure = str_repeat(config('elegan.space'), 8) . $statusCode . ":" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'description: ' . $description . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "content:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "application/json:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "type: object" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "properties:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "message:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . "type: string" . PHP_EOL;

        return $structure;
    }

    public function headerPaginate(array $params): string
    {
        $structure = str_repeat(config('elegan.space'), 6) . "parameters:" . PHP_EOL;

        if (!empty($params)) {
            $structure = $this->header(params: $params);
        }

        $structure .= str_repeat(config('elegan.space'), 8) . "- in: query" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'name: page' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "type: integer" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "required: false" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) .
            "description: Número da página" .
            PHP_EOL;

        $structure .= str_repeat(config('elegan.space'), 8) . "- in: query" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'name: limit' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "type: integer" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "required: false" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) .
            "description: Limite de itens por página" .
            PHP_EOL;

        $structure .= str_repeat(config('elegan.space'), 8) . "- in: query" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'name: sort' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "type: string" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "required: false" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) .
            "description: Campo que deseja ordenar" .
            PHP_EOL;

        $structure .= str_repeat(config('elegan.space'), 8) . "- in: query" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . 'name: order' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "type: string" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "enum:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "- asc" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "- desc" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) .
            "description: Sentido de ordenação (crescente ou decrescente)" .
            PHP_EOL;

        return $structure;
    }
}
