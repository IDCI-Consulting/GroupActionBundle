<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
interface GroupActionInterface
{
    /**
     * Sets group action's alias with the given alias.
     *
     * @return GroupActionInterface
     */
    public function setAlias(string $alias);

    /**
     * Returns group action's alias.
     */
    public function getAlias(): string;

    /**
     * Executes group action with given data.
     */
    public function execute(array $data);
}
