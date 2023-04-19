<?php

namespace Formatters\Json;

function getChangesInJson($astTree)
{
    return json_encode($astTree);
}
