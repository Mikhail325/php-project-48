<?php

namespace Differ\Formatters;

function formatSelection(array $data, string $format): string
{
    $corectFormate = ['stylish', 'plain', 'json'];

    if (in_array($format, $corectFormate)) {
        $render = "Differ\Formatters" . '\\' . $format . '\\' . 'render';
        return $render($data);
    }

    throw new \Exception("Unknown format {$format}");
}
