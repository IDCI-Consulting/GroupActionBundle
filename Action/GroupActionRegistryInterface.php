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
     * @param string               $alias       The group action alias.
     * @param GroupActionInterface $groupAction The group action.
     *
     * @return GroupActionRegistryInterface
     */
    public function setAction($alias, GroupActionInterface $groupAction);

    /**
     * Returns group action by alias.
     *
     * @param string $alias The alias of group action.
     *
     * @return GroupActionInterface
     *
     * @throws Exception\UnexpectedTypeException  If the passed alias is not a string.
     * @throws \InvalidArgumentException If the group action can not be retrieved.
     */
    public function getAction($alias);

    /**
     * Returns whether the given group action is supported.
     *
     * @param string $alias The alias of the group action.
     *
     * @return bool Whether the group action is present.
     */
    public function hasAction($alias);
}
