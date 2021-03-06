<?php declare(strict_types=1);

namespace Lmc\Steward\Utils;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Lmc\Steward\Utils\Strings
 */
class StringsTest extends TestCase
{
    /**
     * @dataProvider provideStringToFilename
     */
    public function testShouldCOnvertStringToFilename(string $string, string $expectedFilename): void
    {
        $this->assertSame($expectedFilename, Strings::toFilename($string));
    }

    /**
     * @return array[]
     */
    public function provideStringToFilename(): array
    {
        return [
            'Convert special chars in class name, keep case' => ['Lmc\Foo\FooBarTest', 'Lmc-Foo-FooBarTest'],
            'Convert special charts in FQN' => ['Lmc\Foo\FooBarTest::bazBan', 'Lmc-Foo-FooBarTest-bazBan'],
            'Convert other special chars' => ['f"o&o/b\'a_r', 'f-o-o-b-a-r'],
            'Convert national chars, do no transliteration' => ['foo žluťoučký KŮŇ bar', 'foo-lu-ou-k-K-bar'],
            'Only one hyphen in sequence' => ['foo-----bar', 'foo-bar'],
            'No hyphens on start or end' => ['&foo&bar&', 'foo-bar'],
            'No hyphens on start or end when spaces encapsulate the text' => ['  foo  ', 'foo'],
            'Only special char => empty string' => ['&', ''],
            'Only spaces => empty string' => ['     ', ''],
            'Empty string => do nothing' => ['', ''],
            'Multiple special chars in sequence => only one hyphen' => ['foo///BAR', 'foo-BAR'],
            'Multiple national chars in sequence => only one hyphen' => ['fooĎŤŇBAR', 'foo-BAR'],
        ];
    }
}
