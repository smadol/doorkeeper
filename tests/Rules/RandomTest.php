<?php
namespace RemotelyLiving\Doorkeeper\Tests\Rules;

use PHPUnit\Framework\TestCase;
use RemotelyLiving\Doorkeeper\Rules\Random;
use RemotelyLiving\Doorkeeper\Rules\TypeMapper;
use RemotelyLiving\Doorkeeper\Utilities\Randomizer;

class RandomTest extends TestCase
{
    /**
     * @test
     */
    public function canBeSatisfied()
    {
        $randomizer = $this->getMockBuilder(Randomizer::class)
          ->setMethods(['mtRand'])
          ->getMock();

        $rule = new Random($randomizer);

        $randomizer->method('mtRand')
          ->with(1, 100)
          ->willReturn(10);

        $this->assertTrue($rule->canBeSatisfied());
    }

    /**
     * @test
     */
    public function getValue()
    {
        $this->assertNull((new Random())->getValue());
    }
}
