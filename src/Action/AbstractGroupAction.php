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
     * @var EntityManagerInterface
     */
    private $om;

    /**
     * @var string
     */
    private $alias;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManagerInterface $om = null)
    {
        $this->om = $om;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Gets EntityManagerInterface.
     *
     * @return EntityManagerInterface
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
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function execute(array $data);
}
