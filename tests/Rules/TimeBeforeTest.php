<?php
namespace RemotelyLiving\Doorkeeper\Tests\Rules;

use PHPUnit\Framework\TestCase;
use RemotelyLiving\Doorkeeper\Rules\TimeAfter;
use RemotelyLiving\Doorkeeper\Rules\TimeBefore;
use RemotelyLiving\Doorkeeper\Utilities\Time;

class TimeBeforeTest extends TestCase
{
    /**
     * @test
     */
    public function cannotBeSatisfied()
    {
        $time = $this->getMockBuilder(Time::class)
          ->setMethods(['getImmutableDateTime'])
          ->getMock();

        $time->method('getImmutableDateTime')
          ->willReturnMap([
              [ 'boop', new \DateTimeImmutable('2011-11-12')],
              [ 'now', new \DateTimeImmutable('2011-12-12')],
          ]);

        $rule = new TimeBefore('boop', $time);

        $this->assertFalse($rule->canBeSatisfied());
    }

    /**
     * @test
     */
    public function canBeSatisfied()
    {
        $time = $this->getMockBuilder(Time::class)
            ->setMethods(['getImmutableDateTime'])
            ->getMock();

        $time->method('getImmutableDateTime')
            ->willReturnMap([
                [ 'boop', new \DateTimeImmutable('2011-12-12')],
                [ 'now', new \DateTimeImmutable('2011-11-12')],
            ]);

        $rule = new TimeBefore('boop', $time);

        $this->assertTrue($rule->canBeSatisfied());
    }

    /**
     * @test
     */
    public function getValue()
    {
        $this->assertEquals('2011-12-12 00:00:00', (new TimeBefore('2011-12-12'))->getValue());
    }
}
