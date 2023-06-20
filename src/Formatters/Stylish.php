<?php

namespace Differ\Formatters\Stylish;

function render(array $astTree, int $depth = 0): string
{
    $lines = array_map(fn ($node) => processingNode($node, $depth), $astTree);
    $indent = getIndent($depth);
    $result = ["{", ...$lines, "{$indent}}"];
    return implode("\n", $result);
}

function processingNode(array $node, int $depth): string
{
    [
        'status' => $status,
        'key' => $key
    ] = $node;

    switch ($status) {
        case 'array':
            return getIndent($depth, ' ') . $key . ": " . render($node['children'], $depth + 1);
        case 'unchanged':
            return getIndent($depth, ' ') . $key . ": " . convertString($node['valueAfter'], $depth);
        case 'added':
            return getIndent($depth, '+') . $key . ": " . convertString($node['valueAfter'], $depth);
        case 'deleted':
            return getIndent($depth, '-') . $key . ": " . convertString($node['valueAfter'], $depth);
        case 'changed':
            return getIndent($depth, '-') . $key . ": " . convertString($node['valueAfter'], $depth) . "\n"
            . getIndent($depth, '+') . $key . ": " . convertString($node['valueBefore'], $depth);
        default:
            throw new \Exception("Unknown status" . $status);
    }
}

function getIndent(int $depth, string $simbol = ''): string
{
    $indent = str_repeat('    ', $depth);
    if ($simbol != false) {
        return $indent . "  " . $simbol . " ";
    }
    return $indent;
}

function convertString(mixed $value, int $depth): mixed
{
    if (is_array($value)) {
        return render($value, $depth + 1);
    } else {
        return $value;
    }
}
