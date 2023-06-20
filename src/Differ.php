<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatters\formatSelection;
use function Functional\sort;

function genDiff(string $firstFile, string $secondFile, string $formate = 'stylish'): string
{
    $file1 = parseData($firstFile);
    $file2 = parseData($secondFile);

    $diff = buildDiffTree($file1, $file2);
    return formatSelection($diff, $formate);
}

function parseData(string $file): array
{
    $filePath = realpath($file);
    if ($filePath === false) {
        throw new \Exception("File not found");
    }
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $data = file_get_contents($filePath);
    return parse($data, $extension);
}

function buildDiffTree(array $firstFile, array $secondFile): array
{
    $keys = array_merge(array_keys($firstFile), array_keys($secondFile));
    $allKeys = array_values(array_unique($keys));
    $sortKey = sort($allKeys, fn($left, $right) => strcmp($left, $right));
    return array_map(function ($key) use ($firstFile, $secondFile) {

        $value1 = $firstFile[$key] ?? null;
        $value2 = $secondFile[$key] ?? null;

        if (!key_exists($key, $secondFile)) {
            return [
                'status' => 'deleted',
                'key' => $key,
                'valueAfter' => setValue($value1)
            ];
        }
        if (!key_exists($key, $firstFile)) {
            return [
                'status' => 'added',
                'key' => $key,
                'valueAfter' => setValue($value2)
            ];
        }
        if (is_array($value1) && is_array($value2)) {
            return [
                'status' => 'array',
                'key' => $key,
                'children' => buildDiffTree($value1, $value2)
            ];
        }
        if ($value1 != $value2) {
            return [
                'status' => 'changed',
                'key' => $key,
                'valueAfter' => setValue($value1),
                'valueBefore' => setValue($value2)
            ];
        }
        return [
            'status' => 'unchanged',
            'key' => $key,
            'valueAfter' => $value1
        ];
    }, $sortKey);
}

function setValue(mixed $data): mixed
{
    if (!is_array($data)) {
        return setString($data);
    }
    return buildDiffTree($data, $data);
}

function setString(mixed $data): string
{
    if (is_null($data)) {
        return 'null';
    }
    return trim(var_export($data, true), "'");
}
