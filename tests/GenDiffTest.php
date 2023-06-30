<?php

namespace GenDigg\GenDiffTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private function getFile(string $nameFile): string
    {
        return realpath(implode('/', ['tests', 'fixtures', $nameFile]));
    }

    /**
     * @dataProvider dataTest
     */

    public function testGenDiff($file1, $file2, $corectFile, $format): void
    {
        $corectAneswer = file_get_contents($this->getFile($corectFile));
        $this->assertEquals(
            $corectAneswer,
            genDiff($this->getFile($file1), $this->getFile($file2), $format)
        );
    }

    public static function dataTest()
    {
        return [
            'testStylish'  => ['file11.json', 'file22.yml', 'corectStylish', 'stylish'],
            'testPlain' => ['file11.json', 'file22.yml', 'corectPlain', 'plain'],
            'testJson' => ['file11.json', 'file22.yml', 'corectJson', 'json']
        ];
    }
}
