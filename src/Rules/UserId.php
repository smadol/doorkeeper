<?php
namespace RemotelyLiving\Doorkeeper\Rules;

use RemotelyLiving\Doorkeeper\Identification;
use RemotelyLiving\Doorkeeper\Requestor;

class UserId extends RuleAbstract
{
    /**
     * @var \RemotelyLiving\Doorkeeper\Identification\IntegerId
     */
    private $user_id;

    /**
     * @param string $feature_id
     * @param int    $hash
     */
    public function __construct(string $feature_id, int $hash)
    {
        parent::__construct($feature_id);

        $this->user_id = new Identification\IntegerId($hash);
    }

    /**
     * @inheritdoc
     */
    protected function childCanBeSatisfied(Requestor $requestor = null): bool
    {
        if (!$this->requestorHasIdentity($requestor, Identification\IntegerId::class)) {
            return false;
        }

        return $requestor->getIdentifiationByClassName(Identification\IntegerId::class)
            ->equals($this->user_id);
    }
}
