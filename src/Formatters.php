<?php

namespace Formatters;

use function Formatters\Stylish\getChangesInStylish;
use function Formatters\Plain\getChangesInPlain;

function formatSelection($data, $formate)
{
    switch ($formate) {
        case ('stylish'):
            return getChangesInStylish($data);
        case ('plain'):
            return getChangesInPlain($data);
        default:
            throw new \Exception("Unknown format {$formate}");
    }
}
