<?php
namespace RemotelyLiving\Doorkeeper\Tests\Rules;

use PHPUnit\Framework\TestCase;
use RemotelyLiving\Doorkeeper\Requestor;
use RemotelyLiving\Doorkeeper\Rules\Environment;
use RemotelyLiving\Doorkeeper\Rules\HttpHeader;
use RemotelyLiving\Doorkeeper\Rules\UserId;

class EnvironmentTest extends TestCase
{
    /**
     * @test
     */
    public function canBeSatisfied()
    {
        $rule      = new Environment('some id', 'DEV');
        $requestor = new Requestor();

        $this->assertFalse($rule->canBeSatisfied());
        $this->assertFalse($rule->canBeSatisfied($requestor));
        $this->assertTrue($rule->canBeSatisfied($requestor->withEnvironment('DEV')));
        $this->assertFalse($rule->canBeSatisfied($requestor->withEnvironment('PROD')));
    }

    /**
     * @test
     */
    public function cannotBeSatisfiedWithFalseyPrereq()
    {
        $rule      = new Environment('some id', 'DEV');
        $prereq    = new HttpHeader('some id', 'headerValue');

        $rule->setPrerequisite($prereq);

        $this->assertTrue($rule->hasPrerequisite());

        $requestor = new Requestor();

        $this->assertFalse($rule->canBeSatisfied());
        $this->assertFalse($rule->canBeSatisfied($requestor));
        $this->assertFalse($rule->canBeSatisfied($requestor->withEnvironment('DEV')));
    }

    /**
     * @test
     */
    public function canBeSatisfiedWithTruthyPrereq()
    {
        $rule      = new Environment('some id', 'DEV');
        $prereq    = new UserId('some id', 321);

        $rule->setPrerequisite($prereq);

        $this->assertTrue($rule->hasPrerequisite());

        $requestor = new Requestor();

        $this->assertFalse($rule->canBeSatisfied());
        $this->assertFalse($rule->canBeSatisfied($requestor));
        $this->assertTrue($rule->canBeSatisfied($requestor->withEnvironment('DEV')->withUserId(321)));
    }

    /**
     * @test
     * @expectedException \DomainException
     */
    public function setPrerequisiteTwice()
    {
        $rule      = new Environment('some id', 'DEV');
        $prereq    = new UserId('some id', 321);

        $rule->setPrerequisite($prereq);
        $rule->setPrerequisite($prereq);
    }
}