<?php

namespace Parsers;

use Symfony\Component\Yaml\Yaml;

function parserData(string $parsFile)
{
    $parsFile = realpath($parsFile);
    $expansion = pathinfo($parsFile, PATHINFO_EXTENSION);
    $data = file_get_contents($parsFile);
    return getParset($data, $expansion);
}

function getParset(string $file, string $expation)
{
    switch($expation){
        case('json'):
            return json_decode($file, true);
        case('yaml'):
        case('yml'):
            return Yaml::parse($file);
    }
}