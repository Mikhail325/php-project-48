<?php

namespace Formatters\Json;

function getChangesInJson(array $astTree): string
{
    return json_encode($astTree);
}
