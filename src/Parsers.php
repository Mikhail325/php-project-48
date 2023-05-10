<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parset(mixed $data, string $expation): array
{
    switch ($expation) {
        case ('json'):
            return json_decode($data, true);
        case ('yaml'):
        case ('yml'):
            return Yaml::parse($data);
        default:
            throw new \Exception("Unknown file format {$expation}");
    }
}
