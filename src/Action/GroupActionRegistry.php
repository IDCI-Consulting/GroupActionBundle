<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

class GroupActionRegistry implements GroupActionRegistryInterface
{
    private array $groupActions = [];

    public function setAction(string $alias, GroupActionInterface $groupAction): GroupActionRegistryInterface
    {
        $groupAction->setAlias($alias);

        $this->groupActions[$alias] = $groupAction;

        return $this;
    }

    public function getAction(?string $alias): GroupActionInterface
    {
        if (!$this->hasAction($alias)) {
            throw new \InvalidArgumentException(sprintf('Could not load group action "%s"', $alias));
        }

        return $this->groupActions[$alias];
    }

    public function hasAction(string $alias): bool
    {
        return isset($this->groupActions[$alias]) ? true : false;
    }
}
