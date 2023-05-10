<?php

namespace Differ\Formatters\stylish;

function render(array $astTree, int $depth = 0): string
{
    $lines = array_map(fn ($node) => processingNode($node, $depth), $astTree);
    $indent = indentation($depth);
    $result = ["{", ...$lines, "{$indent}}"];
    return implode("\n", $result);
}

function processingNode($node, $depth)
{
    [
        'status' => $status,
        'key' => $key,
        'valueAfter' => $valueAfter,
        'valueBefore' => $valueBefore
    ] = $node;

    switch ($status) {
        case 'array':
            return indentation($depth, ' ') . "{$key}: " . render($valueAfter, $depth + 1);
        case 'unchanged':
            return indentation($depth, ' ') . "{$key}: " . convertString($valueAfter, $depth);
        case 'added':
            return indentation($depth, '+') . "{$key}: " . convertString($valueAfter, $depth);
        case 'deleted':
            return indentation($depth, '-') . "{$key}: " . convertString($valueAfter, $depth);
        case 'changed':
            return indentation($depth, '-') . "{$key}: " . convertString($valueAfter, $depth) . "\n"
            . indentation($depth, '+') . "{$key}: " . convertString($valueBefore, $depth);
        default:
            throw new \Exception("Unknown status {$status}");
    }
}

function indentation(int $depth, string $simbol = '')
{
    $indent = str_repeat('    ', $depth);
    if (!empty($simbol)) {
        return $indent . "  {$simbol} ";
    }
    return $indent;
}

function convertString($value, $depth)
{
    if (is_array($value)) {
        return render($value, $depth + 1);
    } else {
        return $value;
    }
}
