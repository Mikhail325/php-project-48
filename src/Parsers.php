<?php

namespace Parsers;

use Symfony\Component\Yaml\Yaml;

function parserData(string $file): array
{
    $parsFile = realpath($file);
    if ($parsFile === false) {
        throw new \Exception("File not found");
    }
    $expansion = pathinfo($parsFile, PATHINFO_EXTENSION);
    $data = file_get_contents($parsFile);
    return getParset($data, $expansion);
}

function getParset(mixed $data, string $expation): array
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
