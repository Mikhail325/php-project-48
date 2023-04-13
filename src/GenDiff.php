<?php

namespace Differ\Differ;

use function Parsers\parserData;

function genDiff($firstFile, $secondFile)
{
    $firstFile = parserData($firstFile);
    $secondFile = parserData($secondFile);

    return comparison($firstFile, $secondFile);
}

function comparison($firstFile, $secondFile)
{
    $keys = array_merge(array_keys($firstFile), array_keys($secondFile));
    $allKeys = array_values(array_unique($keys));
    sort($allKeys);

    $result = array_map(function ($key) use ($firstFile, $secondFile) {

        if (array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
            return "- " . $key . ": " . var_export($firstFile[$key], true);
        }
        if (array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile)) {
            return "+ " . $key . ": " . var_export($secondFile[$key], true);
        }
        if ($firstFile[$key] === $secondFile[$key]) {
            return "  " . $key . ": " . var_export($firstFile[$key], true);
        }
        if ($firstFile[$key] !== $secondFile[$key]) {
            return "+ " . $key . ": " . $secondFile[$key] . "\n" . "- " . $key . ": " . $firstFile[$key];
        }
    }, $allKeys);

    return implode("\n", $result);
}
