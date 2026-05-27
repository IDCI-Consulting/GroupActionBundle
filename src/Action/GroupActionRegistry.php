<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

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
    public function setAction(string $alias, GroupActionInterface $groupAction): GroupActionRegistryInterface
    {
        // Set the group action alias
        $groupAction->setAlias($alias);

        $this->groupActions[$alias] = $groupAction;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAction(?string $alias): GroupActionInterface
    {
        if (!$this->hasAction($alias)) {
            throw new \InvalidArgumentException(sprintf('Could not load group action "%s"', $alias));
        }

        return $this->groupActions[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function hasAction(string $alias): bool
    {
        return isset($this->groupActions[$alias]) ? true : false;
    }
}
