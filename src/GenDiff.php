<?php

namespace Differ\Differ;

use function Parsers\parserData;
use function Formatters\formatSelection;
use function Functional\sort;

function genDiff(string $firstFile, string $secondFile, string $formate = 'stylish'): string
{
    $file1 = parserData($firstFile);
    $file2 = parserData($secondFile);

    $diff = comparation($file1, $file2);
    return formatSelection($diff, $formate);
}

function comparation(array $firstFile, array $secondFile): array
{
    $keys = array_merge(array_keys($firstFile), array_keys($secondFile));
    $allKeys = array_values(array_unique($keys));
    $sortKey = sort($allKeys, fn($a, $b) => strcmp($a, $b));
    return array_map(function ($key) use (&$firstFile, &$secondFile) {

        $value1 = $firstFile[$key] ?? null;
        $value2 = $secondFile[$key] ?? null;

        if (!key_exists($key, $secondFile)) {
            return setNode('deleted', $key, setString($value1));
        }
        if (!key_exists($key, $firstFile)) {
            return setNode('added', $key, setString($value2));
        }
        if (is_array($firstFile[$key]) && is_array($secondFile[$key])) {
            return setNode('array', $key, comparation($value1, $value2));
        }
        if ($firstFile[$key] !== $secondFile[$key]) {
            return setNode('changed', $key, setString($value1), setString($value2));
        }
        return setNode('unchanged', $key, $value1);
    }, $sortKey);
}

function setNode(string $status, string $key, mixed $value1, mixed $value2 = null): array
{
    return [
        'status' => $status,
        'key' => $key,
        'valueAfter' => $value1,
        'valueBefore' => $value2
    ];
}


function setString(mixed $data): mixed
{
    $iter = function ($data) use (&$iter) {
        if (!is_array($data)) {
            if (is_null($data)) {
                return 'null';
            }
            return trim(var_export($data, true), "'");
        }

        $keys = array_keys($data);
        return array_map(function ($key) use ($data, $iter) {
            $value = (is_array($data[$key])) ? $iter($data[$key]) : $data[$key];
            return setNode('unchanged', $key, $value);
        }, $keys);
    };

    return $iter($data);
}
