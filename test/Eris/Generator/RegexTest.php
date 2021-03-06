<?php
namespace Eris\Generator;

class RegexTest extends \PHPUnit_Framework_TestCase
{
    public static function supportedRegexes()
    {
        return [
            // [".{0,100}"] sometimes generates NULL 
            ["[a-z0-9]{24}"],
            ["[a-z]{1,5}"],
            ["^[a-z]$"],
            ["a|b|c"],
            ["\d\s\w"],
        ];
    }

    /**
     * @dataProvider supportedRegexes
     */
    public function testGeneratesOnlyValuesThatMatchTheRegex($expression)
    {
        $generator = new Regex($expression);
        for ($i = 0; $i < 100; $i++) {
            $value = $generator();
            $this->assertTrue($generator->contains($value), "Failed asserting that " . var_export($value, true) . " matches the regexp $expression");
        }
    }  

    public function testShrinkingIsNotImplementedYet()
    {
        $generator = new Regex(".*");
        $this->assertEquals("something", $generator->shrink("something"));
    }
}
