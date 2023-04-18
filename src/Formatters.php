<?php

namespace Formatters;

use function Formatters\Stylish\outputOfChanges;

function formatSelection($data, $format)
{
    switch ($format) {
        case ('stylish'):
            return outputOfChanges($data);
        default:
            throw new \Exception("Unknown format {$format}");
    }
}
