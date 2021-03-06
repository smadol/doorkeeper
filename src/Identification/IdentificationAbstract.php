<?php
namespace RemotelyLiving\Doorkeeper\Identification;

abstract class IdentificationAbstract
{
    /**
     * @var int|float|string
     */
    private $identifier;

    /**
     * @var mixed
     */
    private $identity_hash;

    /**
     * @var string
     */
    private $type;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct($identifier)
    {
        if (!is_scalar($identifier) || is_bool($identifier)) {
            throw new \InvalidArgumentException('Identifier must be a scalar, alpha numeric value');
        }

        $this->validate($identifier);

        $this->identifier    = $identifier;
        $this->type          = get_class($this);
        $this->identity_hash = md5($this->getType(). (string)$identifier);
    }

    /**
     * @return mixed
     */
    final public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    final public function getType(): string
    {
        return $this->type;
    }

    final public function equals(IdentificationAbstract $identity): bool
    {
        return $this->getUniqueIdentityHash() === $identity->getUniqueIdentityHash();
    }

    /**
     * @throws \InvalidArgumentException
     */
    abstract protected function validate($value);

    /**
     * @return string
     */
    private function getUniqueIdentityHash(): string
    {
        return $this->identity_hash;
    }
}
