<?php

namespace Differ\Formatters;

function formatSelection(array $data, string $format): string
{
    $corectFormate = ['stylish', 'plain', 'json'];
    $render = "Differ\Formatters" . '\\' . $format . '\\' . 'render';

    if (in_array($format, $corectFormate, true)) {
        return $render($data);
    }

    throw new \Exception("Unknown format {$format}");
}
