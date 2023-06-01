<?php

namespace Differ\Formatters;

use function Differ\Formatters\Json\render as renderJson;
use function Differ\Formatters\Plain\render as renderPlain;
use function Differ\Formatters\Stylish\render as renderStylish;

function formatSelection(array $data, string $format): string
{
    switch ($format) {
        case 'stylish':
            return renderStylish($data);
        case 'plain':
            return renderPlain($data);
        case 'json':
            return renderJson($data);
        default:
            throw new \Exception("Unknown format $format");
    }
}
