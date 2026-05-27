<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
interface GroupActionRegistryInterface
{
    /**
     * Sets a group action identified by an alias.
     *
     * @param string               $alias       the group action alias
     * @param GroupActionInterface $groupAction the group action
     *
     * @return GroupActionRegistryInterface
     */
    public function setAction(string $alias, GroupActionInterface $groupAction): self;

    /**
     * Returns group action by alias.
     *
     * @param string $alias the alias of group action
     *
     * @return GroupActionInterface
     *
     * @throws Exception\UnexpectedTypeException if the passed alias is not a string
     * @throws \InvalidArgumentException         if the group action can not be retrieved
     */
    public function getAction(?string $alias): GroupActionInterface;

    /**
     * Returns whether the given group action is supported.
     *
     * @param string $alias the alias of the group action
     *
     * @return bool whether the group action is present
     */
    public function hasAction(string $alias): bool;
}
