<?php

namespace Formatters\Plain;

function getChangesInPlain(array $astTree, string $wayValue = ''): string
{
    $result = array_map(function ($node) use ($wayValue) {

        [
            'status' => $status,
            'key' => $key,
            'valueAfter' => $valueAfter,
            'valueBefore' => $valueBefore
        ] = $node;

        $normalizeValue1 = ('' === $wayValue) ? $key : "{$wayValue}.{$key}";

        switch ($status) {
            case 'array':
                return getChangesInPlain($valueAfter, $normalizeValue1);
            case 'added':
                $after = outputValue($valueAfter);
                return "Property '{$normalizeValue1}' was added with value: {$after}";
            case 'deleted':
                return "Property '{$normalizeValue1}' was removed";
            case 'changed':
                $after = outputValue($valueAfter);
                $before = outputValue($valueBefore);
                return "Property '{$normalizeValue1}' was updated. From {$after} to {$before}";
        }
    }, $astTree);
    $filterResult = array_filter($result);
    return implode("\n", $filterResult);
}


function outputValue(mixed $value): mixed
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
