<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

use Doctrine\ORM\EntityManagerInterface;
use IDCI\Bundle\GroupActionBundle\Exception\ObjectManagerMissingException;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
abstract class AbstractGroupAction implements GroupActionInterface
{
    /**
     * @var EntityManagerInterface|null
     */
    private $om;

    /**
     * @var string|null
     */
    private $alias;

    /**
     * Constructor.
     */
    public function __construct(?EntityManagerInterface $om = null)
    {
        $this->om = $om;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Gets EntityManagerInterface.
     */
    public function getObjectManager(): ?EntityManagerInterface
    {
        if (null === $this->om) {
            throw new ObjectManagerMissingException(get_called_class());
        }

        return $this->om;
    }

    /**
     * To string.
     */
    public function __toString(): string
    {
        return $this->getAlias();
    }

    abstract public function execute(array $data);
}
