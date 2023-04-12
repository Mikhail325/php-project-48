<?php

namespace GenDigg\GenDiffTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiff(): void
    {
        $this->assertEquals(
            "- follow: false
  host: 'hexlet.io'
- proxy: '123.234.53.22'
+ timeout: 20
- timeout: 50
+ verbose: true",
            genDiff(realpath('tests/fixtures/file1.json'), realpath('tests/fixtures/file2.json'))
        );
    }
}
