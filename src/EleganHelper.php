<?php

namespace Labi9\Elegan;

use Labi9\Elegan\Elegan;
use Symfony\Component\Yaml\Yaml;

class EleganHelper
{
    public function createRoute(string $originalPath, array $actions, bool $auth, array $names): string
    {
        $path = str_replace(
            config('elegan.parameter_identify'),
            '',
            $originalPath
        );
        $fileName = config('elegan.default_main_yaml');
        $filePath = config('elegan.route_path') . '/' . $path . $fileName;

        $this->createFolder($path);

        $params = $this->verifyIfParamExist($originalPath);
        $structure = $this->structure(
            $auth,
            $actions,
            $path,
            $params,
            $names,
        );


        file_put_contents($filePath, $structure, FILE_APPEND);

        return $path . $fileName;
    }

    private function verifyIfParamExist(string $originalPath): array
    {
        $params = [];
        $explodePath = explode(
            '/',
            $originalPath
        );

        foreach ($explodePath as $currentPath) {
            $hasParameter = strpos($currentPath, config('elegan.parameter_identify')) === false;

            if (!$hasParameter) {
                $params[] = substr($currentPath, 1);
            }
        }

        return $params;
    }

    private function createFolder(string $path): void
    {
        $fullPath = config('elegan.route_path');

        $explodePath = explode('/', $path);

        foreach ($explodePath as $folder) {
            $currentPath = '/' . $folder;

            if (!is_dir($fullPath . $currentPath)) {
                mkdir($fullPath . $currentPath, 755, true);
            }

            $fullPath .= $currentPath;
        }
    }

    private function structure(bool $auth, array $actions, string $path, array $params, array $names): string
    {
        $structure = PHP_EOL;
        $elegan = new Elegan();

        $structure .= $elegan->handle(
            $actions,
            $auth,
            $path,
            $params,
            $names,
        );

        return $structure;
    }

    public function patchNoteFiles(): array
    {
        $path = config('elegan.patch_note_path');

        if (!is_dir($path)) {
            mkdir($path, 755, true);
        }

        $fileNames = scandir($path);
        $fileNames = array_diff(scandir($path), array('.', '..'));
        $fileContent = [];

        foreach ($fileNames as $name) {
            $fileContent[] = Yaml::parseFile($path . '/' . $name);
        }

        return array_reverse($fileContent);
    }
}
