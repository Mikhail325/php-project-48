<?php

namespace GenDigg\GenDiffTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private function getPathFile(string $nameFile): string
    {
        return 'tests' . DIRECTORY_SEPARATOR . 'fixtures'
        . DIRECTORY_SEPARATOR . $nameFile;
    }

    public function testGenDiffJson(): void
    {
        $corectAneswe = file_get_contents($this -> getPathFile('corectAnswe'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file1.json'), $this -> getPathFile('file2.json'))
        );
    }

    public function testGenDiffYaml(): void
    {
        $corectAneswe = file_get_contents($this -> getPathFile('corectAnswe'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file1.yml'), $this -> getPathFile('file2.yml'))
        );
    }
}
