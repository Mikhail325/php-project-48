<?php

namespace Formatters;

use function Formatters\Stylish\getChangesInStylish;
use function Formatters\Plain\getChangesInPlain;
use function Formatters\Json\getChangesInJson;

function formatSelection($data, $formate)
{
    switch ($formate) {
        case ('stylish'):
            return getChangesInStylish($data);
        case ('plain'):
            return getChangesInPlain($data);
        case ('json'):
            return getChangesInJson($data);
        default:
            throw new \Exception("Unknown format {$formate}");
    }
}
