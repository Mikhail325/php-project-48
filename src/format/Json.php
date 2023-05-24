<?php

namespace Differ\Formatters\json;

function renderJson(array $tree): string
{
    return json_encode($tree, JSON_THROW_ON_ERROR);
}
