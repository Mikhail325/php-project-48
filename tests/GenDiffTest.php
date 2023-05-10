<?php

namespace GenDigg\GenDiffTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private function getPathFile(string $nameFile): string
    {
        return 'file' . DIRECTORY_SEPARATOR . $nameFile;
    }

    private function getCorectAnswer(string $nameFile): string
    {
        return 'tests' . DIRECTORY_SEPARATOR . 'fixtures'
        . DIRECTORY_SEPARATOR . $nameFile;
    }

    public function testGenDiffStylish(): void
    {
        $corectAneswe = file_get_contents($this->getCorectAnswer('corectStylish'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this->getPathFile('file11.json'), $this->getPathFile('file22.yml'))
        );
    }

    public function testGenDiffFormatPlain(): void
    {
        $corectAneswe = file_get_contents($this->getCorectAnswer('corectPlain'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this->getPathFile('file11.json'), $this->getPathFile('file22.yml'), 'plain')
        );
    }

    public function testGenDiffFormatJson(): void
    {
        $corectAneswe = file_get_contents($this->getCorectAnswer('corectJson'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this->getPathFile('file11.json'), $this->getPathFile('file22.yml'), 'json')
        );
    }
}
