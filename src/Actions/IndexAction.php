<?php

namespace Jcsfran\Elegan\Actions;

use Jcsfran\Elegan\Contracts\{
    Action,
    EleganInterface,
};
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class IndexAction extends Action implements EleganInterface
{
    public function struct(bool $auth, string $path, array $params, $name): string
    {
        $structuredYaml = str_repeat(config('elegan.space'), 4) . "get:" . PHP_EOL;
        $structuredYaml .=
            str_repeat(config('elegan.space'), 6)
            . '$ref: ./'
            . $name
            . '.yaml'
            . PHP_EOL;

        $this->createStructure(
            $auth,
            $path,
            $params,
            $name,
        );

        return $structuredYaml;
    }

    private function bodyStructure(): string
    {
        $statusCode = HttpResponse::HTTP_OK;
        $structure = str_repeat(config('elegan.space'), 6) . "tags:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "summary: ''" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "consumes:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- 'application/json'" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "produces:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . "- 'application/json'" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 6) . "responses:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 8) . $statusCode . ":" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) .
            "description: " .
            HttpResponse::$statusTexts[$statusCode] .
            PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 10) . "content:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 12) . "application/json:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 14) . "schema:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "type: object" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 16) . "properties:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "links:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . 'type: object' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . 'properties:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'first:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'last:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'prev:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'next:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "meta:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . '$type: object' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . 'properties:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'current_page:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'from:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'last_page:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'links:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: array' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'items:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 26) . 'type: object' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 26) . 'properties:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 28) . 'url:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 30) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 28) . 'label:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 30) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 28) . 'active:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 30) . 'type: boolean' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'path:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: string' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'per_page:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'to:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . 'total:' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . 'type: integer' . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 18) . "data:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . "type: array" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 20) . "items:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . "type: object" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 22) . "properties:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 24) . "#input:" . PHP_EOL;
        $structure .= str_repeat(config('elegan.space'), 26) . "#type: integer" . PHP_EOL;

        return $structure;
    }

    public function createStructure(bool $auth, string $path, array $params, string $name): void
    {
        $structure = PHP_EOL;
        $fileName = '/' . $name . '.yaml';

        if ($auth) {
            $structure .= $this
                ->authStructure
                ->header();
        }

        $structure .= $this
            ->paramsStructure
            ->headerPaginate($params);
        $structure .= $this->bodyStructure();

        if ($auth) {
            $structure .= $this
                ->authStructure
                ->response();
        }

        if (!empty($params)) {
            $structure .= $this
                ->paramsStructure
                ->response();
        }

        $this
            ->basicStructure
            ->createFile(
                $fileName,
                $structure,
                $path,
            );
    }
}
