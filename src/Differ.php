<?php

namespace Differ\Differ;

use function Differ\Parsers\parset;
use function Differ\Formatters\formatSelection;
use function Functional\sort;

function genDiff(string $firstFile, string $secondFile, string $formate = 'stylish'): string
{
    $file1 = parserData($firstFile);
    $file2 = parserData($secondFile);

    $diff = buildDiffTree($file1, $file2);
    return formatSelection($diff, $formate);
}

function parserData(string $file): array
{
    $parsFile = realpath($file);
    if ($parsFile === false) {
        throw new \Exception("File not found");
    }
    $expansion = pathinfo($parsFile, PATHINFO_EXTENSION);
    $data = file_get_contents($parsFile);
    return parset($data, $expansion);
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
            return setNode('deleted', $key, setValue($value1));
        }
        if (!key_exists($key, $firstFile)) {
            return setNode('added', $key, setValue($value2));
        }
        if (is_array($value1) && is_array($value2)) {
            return setNode('array', $key, buildDiffTree($value1, $value2));
        }
        if ($value1 !== $value2) {
            return setNode('changed', $key, setValue($value1), setValue($value2));
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

function setValue(mixed $data): mixed
{
    if (!is_array($data)) {
        return setString($data);
    }
    return setArray($data);
}

function setString(mixed $data)
{
    if (is_null($data)) {
        return 'null';
    }
    return trim(var_export($data, true), "'");
}

function setArray(array $data)
{
    $keys = array_keys($data);
        return array_map(function ($key) use ($data) {
            $value = (is_array($data[$key])) ? setValue($data[$key]) : $data[$key];
            return setNode('unchanged', $key, $value);
        }, $keys);
}
