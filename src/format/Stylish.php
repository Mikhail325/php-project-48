<?php

namespace Formatters\Stylish;

function getChangesInStylish(array $astTree, int $depth = 0): string
{
    $indent = str_repeat('    ', $depth);

    $lines = array_map(function ($node) use ($indent, $depth) {

        ['status' => $status, 'key' => $key, 'valueAfter' => $valueAfter, 'valueBefore' => $valueBefore] = $node;

        $normalizeValue1 = (is_array($valueAfter)) ? getChangesInStylish($valueAfter, $depth + 1) : $valueAfter;

        switch ($status) {
            case 'array':
            case 'unchanged':
                return "{$indent}    {$key}: {$normalizeValue1}";
            case 'added':
                return "{$indent}  + {$key}: {$normalizeValue1}";
            case 'deleted':
                return "{$indent}  - {$key}: {$normalizeValue1}";
            case 'changed':
                $normalizeValue2 = (is_array($valueBefore)) ? getChangesInStylish($valueBefore, $depth + 1) : $valueBefore;
                return "{$indent}  - {$key}: {$normalizeValue1}\n{$indent}  + {$key}: {$normalizeValue2}";
        }
    }, $astTree);
    $result = ["{", ...$lines, "{$indent}}"];
    return implode("\n", $result);
}
