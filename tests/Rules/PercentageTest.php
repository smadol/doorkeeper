<?php
namespace RemotelyLiving\Doorkeeper\Tests\Rules;

use PHPUnit\Framework\TestCase;
use RemotelyLiving\Doorkeeper\Rules\Percentage;
use RemotelyLiving\Doorkeeper\Utilities\Randomizer;

class PercentageTest extends TestCase
{
    /**
     * @test
     */
    public function canBeSatisfied()
    {
        $randomizer = $this->getMockBuilder(Randomizer::class)
          ->setMethods(['mtRand'])
          ->getMock();

        $rule = new Percentage('some id', 5, $randomizer);

        $randomizer
          ->method('mtRand')
          ->willReturnMap([
            [ 1, 100, 3 ],
            [ 1, 5, 3 ]
          ]);

        $this->assertTrue($rule->canBeSatisfied());
    }

    /**
     * @test
     */
    public function canBeSatisfied100PercentChance()
    {
        $rule = new Percentage('some id', 100);

        $this->assertTrue($rule->canBeSatisfied());
    }

    /**
     * @test
     */
    public function canBeSatisfied0PercentChance()
    {
        $rule = new Percentage('some id', 0);

        $this->assertFalse($rule->canBeSatisfied());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function invalidPercentageOverOneHundred()
    {
        new Percentage('boop', 101);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function invalidPercentageNegativeNumber()
    {
        new Percentage('boop', -1);
    }
}