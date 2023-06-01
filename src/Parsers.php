<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(mixed $data, string $formatName): array
{
    switch ($formatName) {
        case 'json':
            return json_decode($data, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($data);
        default:
            throw new \Exception("Unknown file format $formatName");
    }
}
