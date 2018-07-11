<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

use Doctrine\Common\Persistence\ObjectManager;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
abstract class AbstractGroupAction implements GroupActionInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var string
     */
    private $alias;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager.
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getActions()
    {
        $actions = array();
        $reflectionClass = new \ReflectionClass($this);

        foreach ($reflectionClass->getMethods() as $method) {
            if (preg_match("/^execute[a-zA-Z0-9]+/", $method->name)) {
                $actions[] = str_replace('execute', '', $method->name);
            }
        }

        return $actions;
    }

    /**
     * Gets ObjectManager.
     *
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->om;
    }

    /**
     * Gets Repository.
     *
     * @return Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository()
    {
        return $this->om->getRepository($this->getObjectClassName());
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function execute(array $data);

    /**
     * {@inheritdoc}
     */
    abstract public function getObjectClassName();

    /**
     * {@inheritdoc}
     */
    abstract public function getName();
}
