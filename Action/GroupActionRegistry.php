<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

use IDCI\Bundle\GroupActionBundle\Exception\UnexpectedTypeException;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class GroupActionRegistry implements GroupActionRegistryInterface
{
    /**
     * @var GroupActionInterface[]
     */
    private $groupActions = array();

    /**
     * {@inheritdoc}
     */
    public function setAction($alias, GroupActionInterface $groupAction)
    {
        // Set the group action alias
        $groupAction->setAlias($alias);

        $this->groupActions[$alias] = $groupAction;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAction($alias)
    {
        if (!is_string($alias)) {
            throw new UnexpectedTypeException($alias, 'string');
        }

        if (!isset($this->groupActions[$alias])) {
            throw new \InvalidArgumentException(sprintf('Could not load group action "%s"', $alias));
        }

        return $this->groupActions[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function hasAction($alias)
    {
        return isset($this->groupActions[$alias]) ? true : false;
    }
}
