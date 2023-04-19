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

    private function getCorectAnswe(string $nameFile): string
    {
        return 'tests' . DIRECTORY_SEPARATOR . 'fixtures'
        . DIRECTORY_SEPARATOR . $nameFile;
    }

    public function testGenDiffJson(): void
    {
        $corectAneswe = file_get_contents($this -> getCorectAnswe('corectAnswe'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file1.json'), $this -> getPathFile('file2.json'))
        );
    }

    public function testGenDiffYaml(): void
    {
        $corectAneswe = file_get_contents($this -> getCorectAnswe('corectAnswe'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file1.yml'), $this -> getPathFile('file2.yml'))
        );
    }

    public function testGenDiffStylishJson(): void
    {
        $corectAneswe = file_get_contents($this -> getCorectAnswe('corectStylish'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file11.json'), $this -> getPathFile('file22.json'))
        );
    }

    public function testGenDiffStylisYaml(): void
    {
        $corectAneswe = file_get_contents($this -> getCorectAnswe('corectStylish'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file11.yml'), $this -> getPathFile('file22.yml'))
        );
    }

    public function testGenDiffPlainJson(): void
    {
        $corectAneswe = file_get_contents($this -> getCorectAnswe('corectPlain'));
        $this->assertEquals(
            $corectAneswe,
            genDiff($this -> getPathFile('file11.json'), $this -> getPathFile('file22.json'), 'plain')
        );
    }
}
