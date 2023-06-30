<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatters\formatSelection;
use function Functional\sort;

function genDiff(string $firstFile, string $secondFile, string $formate = 'stylish'): string
{
    $data1 = parseData($firstFile);
    $data2 = parseData($secondFile);

    $diff = buildDiffTree($data1, $data2);
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

function buildDiffTree(array $firstData, array $secondData): array
{
    $keys = array_merge(array_keys($firstData), array_keys($secondData));
    $allKeys = array_values(array_unique($keys));
    $sortKey = sort($allKeys, fn($left, $right) => strcmp($left, $right));
    return array_map(function ($key) use ($firstData, $secondData) {

        $value1 = $firstData[$key] ?? null;
        $value2 = $secondData[$key] ?? null;

        if (is_array($value1) && is_array($value2)) {
            return [
                'status' => 'nested',
                'key' => $key,
                'children' => buildDiffTree($value1, $value2)
            ];
        }
        $correctValue1 = setValue($value1);
        $correctValue2 = setValue($value2);
        if (!key_exists($key, $secondData)) {
            return [
                'status' => 'deleted',
                'key' => $key,
                'value1' => $correctValue1
            ];
        }
        if (!key_exists($key, $firstData)) {
            return [
                'status' => 'added',
                'key' => $key,
                'value1' => $correctValue2
            ];
        }
        if ($correctValue1 !== $correctValue2) {
            return [
                'status' => 'changed',
                'key' => $key,
                'value1' => $correctValue1,
                'value2' => $correctValue2
            ];
        }
        return [
            'status' => 'unchanged',
            'key' => $key,
            'value1' => $value1
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
