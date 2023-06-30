<?php

namespace Differ\Formatters\Plain;

function render(array $astTree, string $wayValue = ''): string
{
    $result = array_map(fn ($node) => processNode($node, $wayValue), $astTree);
    $filteredResult = array_filter($result);
    return implode("\n", $filteredResult);
}

function processNode(array $node, string $wayValue): mixed
{
    [
        'status' => $status,
        'key' => $key
    ] = $node;

    $normalizedValue = ('' === $wayValue) ? $key : $wayValue . "." . $key;

    switch ($status) {
        case 'nested':
            return render($node['children'], $normalizedValue);
        case 'added':
            $after = getOutputValue($node['value1']);
            return "Property '" . $normalizedValue . "' was added with value: " . $after;
        case 'deleted':
            return "Property '" . $normalizedValue . "' was removed";
        case 'changed':
            $after = getOutputValue($node['value1']);
            $before = getOutputValue($node['value2']);
            return "Property '" . $normalizedValue . "' was updated. From " . $after . " to " . $before;
        case 'unchanged':
            return '';
        default:
            throw new \Exception("Unknown status" . $status);
    }
}

function getOutputValue(mixed $value): mixed
{
    if (is_array($value)) {
        return "[complex value]";
    }

    if (
        $value === 'null' ||
        $value === 'true' ||
        $value === 'false'
    ) {
        return $value;
    }

    if (is_numeric($value)) {
        return (string) $value;
    }

    return "'" . $value . "'";
}
