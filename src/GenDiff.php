<?php

namespace Differ\Differ;

use function Parsers\parserData;
use function Formatters\formatSelection;

function genDiff($firstFile, $secondFile, $formate = 'stylish')
{
    $firstFile = parserData($firstFile);
    $secondFile = parserData($secondFile);

    $result = setComparation($firstFile, $secondFile);
    return formatSelection($result, $formate);
}

function setComparation($firstFile, $secondFile)
{
    $keys = array_merge(array_keys($firstFile), array_keys($secondFile));
    $allKeys = array_values(array_unique($keys));
    sort($allKeys);
    return array_map(function ($key) use (&$firstFile, &$secondFile) {

        $value1 = $firstFile[$key] ?? null;
        $value2 = $secondFile[$key] ?? null;

        if (!key_exists($key, $secondFile)) {
            return setNode('deleted', $key, stringify($value1));;
        }
        if (!key_exists($key, $firstFile)) {
            return setNode('added', $key, stringify($value2));;
        }
        if (is_array($firstFile[$key]) && is_array($secondFile[$key])) {
            return setNode('array', $key, setComparation($value1, $value2));
        }
        if ($firstFile[$key] !== $secondFile[$key]) {
            return setNode('changed', $key, stringify($value1), stringify($value2));
        }
        return setNode('unchanged', $key, $value1);
    }, $allKeys);
}

function setNode(string $status, string $key, $value1, $value2 = null)
{
    return ['status' => $status, 'key' => $key, 'valueAfter' => $value1, 'valueBefore' => $value2];
}


function stringify($content)
{
    $iter = function ($content) use (&$iter) {
        if (!is_array($content)) {
            if ($content === null) {
                return 'null';
            }
            return trim(var_export($content, true), "'");
        }

        $keys = array_keys($content);
        return array_map(function ($key) use ($content, $iter) {
            $value = (is_array($content[$key])) ? $iter($content[$key]) : $content[$key];

            return setNode('unchanged', $key, $value);
        }, $keys);
    };

    return $iter($content);
}