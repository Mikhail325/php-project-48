<?php

namespace Differ\Formatters;

function formatSelection(array $data, string $format): string
{
    switch ($format) {
        case 'stylish':
            return  Stylish\render($data);
        case 'plain':
            return Plain\render($data);
        case 'json':
            return Json\render($data);
        default:
            throw new \Exception("Unknown format $format");
    }
}
