<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use IDCI\Bundle\GroupActionBundle\Exception\ObjectManagerMissingException;

abstract class AbstractGroupAction implements GroupActionInterface
{
    private EntityManagerInterface $om;
    private string $alias;

    public function __construct(EntityManagerInterface $om = null)
    {
        $this->om = $om;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getObjectManager(): ?EntityManagerInterface
    {
        if (null === $this->om) {
            throw new ObjectManagerMissingException(get_called_class());
        }

        return $this->om;
    }

    public function __toString(): string
    {
        return $this->getAlias();
    }

    abstract public function execute(array $data): mixed;
}
