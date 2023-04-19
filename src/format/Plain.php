<?php

namespace Formatters\Plain;

function getChangesInPlain($astTree, $wayValue = '')
{
    $result = array_map(function ($node) use ($wayValue) {

        ['status' => $status, 'key' => $key, 'valueAfter' => $valueAfter, 'valueBefore' => $valueBefore] = $node;

        $normalizeValue1 = ('' === $wayValue) ? $key : "{$wayValue}.{$key}";

        switch ($status) {
            case 'array':
                return getChangesInPlain($valueAfter, $normalizeValue1);
            case 'added':
                $valueAfter = outputValue($valueAfter);
                return "Property '{$normalizeValue1}' was added with value: {$valueAfter}";
            case 'deleted':
                $valueAfter = outputValue($valueAfter);
                return "Property '{$normalizeValue1}' was removed";
            case 'changed':
                $valueAfter = outputValue($valueAfter);
                $valueBefore = outputValue($valueBefore);
                return "Property '{$normalizeValue1}' was updated. From {$valueAfter} to {$valueBefore}";
        }
    }, $astTree);
    $result = array_filter($result);
    return implode("\n", $result);
}


function outputValue($value)
{
    if (!is_array($value)) {
        if (
            $value === 'null' || 
            $value === 'true' || 
            $value === 'false' || 
            is_numeric($value)
            ) {
            return $value;
        }

        return "'{$value}'";
    }
    return "[complex value]";
}
