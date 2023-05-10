<?php

namespace Differ\Formatters\plain;

function render(array $astTree, string $wayValue = ''): string
{
    $result = array_map(fn ($node) => processingNode($node, $wayValue), $astTree);
    $filterResult = array_filter($result);
    return implode("\n", $filterResult);
}

function processingNode(array $node, string $wayValue)
{
    [
        'status' => $status,
        'key' => $key,
        'valueAfter' => $valueAfter,
        'valueBefore' => $valueBefore
    ] = $node;

    $normalizeValue = ('' === $wayValue) ? $key : "{$wayValue}.{$key}";

    switch ($status) {
        case 'array':
            return render($valueAfter, $normalizeValue);
        case 'added':
            $after = getOutputValue($valueAfter);
            return "Property '{$normalizeValue}' was added with value: {$after}";
        case 'deleted':
            return "Property '{$normalizeValue}' was removed";
        case 'changed':
            $after = getOutputValue($valueAfter);
            $before = getOutputValue($valueBefore);
            return "Property '{$normalizeValue}' was updated. From {$after} to {$before}";
        case 'unchanged':
            return;
        default:
            throw new \Exception("Unknown status {$status}");
    }
}

function getOutputValue(mixed $value): mixed
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
