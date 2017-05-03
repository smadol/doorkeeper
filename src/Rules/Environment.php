<?php
namespace RemotelyLiving\Doorkeeper\Rules;

use RemotelyLiving\Doorkeeper\Identification;
use RemotelyLiving\Doorkeeper\Requestor;

class Environment extends RuleAbstract
{
    /**
     * @var \RemotelyLiving\Doorkeeper\Identification\Environment
     */
    private $environment;

    /**
     * @param string $feature_id
     * @param string $environment
     */
    public function __construct(string $feature_id, string $environment)
    {
        parent::__construct($feature_id);

        $this->environment = new Identification\Environment($environment);
    }

    /**
     * @inheritdoc
     */
    protected function childCanBeSatisfied(Requestor $requestor = null): bool
    {
        if (!$this->requestorHasIdentity($requestor, Identification\Environment::class)) {
            return false;
        }

        return $requestor->getIdentifiationByClassName(Identification\Environment::class)
            ->equals($this->environment);
    }
}
