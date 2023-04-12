<?php

namespace Cli;

use function Differ\Differ\genDiff;

const DOC = <<<DOC
gendiff -h

Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: stylish]
DOC;

function run()
{
    $args = \Docopt::handle(DOC, array('version' => 'GenDiff 1.0'));
    $firstFilePath = realpath($args['<firstFile>']);
    $secondFilePath = realpath($args['<secondFile>']);
    $diff = genDiff($firstFilePath, $secondFilePath);
    print_r($diff)  ;
}
