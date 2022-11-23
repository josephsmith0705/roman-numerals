<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require './src/Converter.php';
final class ConverterTest extends TestCase
{
    private $converter;
    
    protected function setup(): void {

        $this->converter = new Converter;
    }

    public function infoProvider(): array
    {
        return [
            [1, "I"],
            [5, "V"],
            [10, "X"]
        ];
    }

    /**
     * @dataProvider infoProvider
     */
    public function testReturnsCorrectValues(int $givenNumber, string $expectedNumeral): void
    {
        $this->assertEquals($this->converter->run($givenNumber), $expectedNumeral);
    }

}
