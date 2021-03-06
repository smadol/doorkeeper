<?php
namespace RemotelyLiving\Doorkeeper\Rules;

use RemotelyLiving\Doorkeeper\Identification;
use RemotelyLiving\Doorkeeper\Requestor;

class PipedComposite extends RuleAbstract
{
    /**
     * @var Identification\PipedComposite
     */
    private $piped_composite;

    public function __construct(string $piped_composite)
    {
        $this->piped_composite = new Identification\PipedComposite($piped_composite);
    }

    public function getValue()
    {
        return $this->piped_composite->getIdentifier();
    }

    protected function childCanBeSatisfied(Requestor $requestor = null): bool
    {
        return $this->requestorHasMatchingId($requestor, $this->piped_composite);
    }
}
