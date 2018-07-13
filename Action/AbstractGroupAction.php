<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\GroupActionBundle\Exception\ObjectManagerMissingException;

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
    public function __construct(ObjectManager $om = null)
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
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAlias();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function execute(array $data);
}
