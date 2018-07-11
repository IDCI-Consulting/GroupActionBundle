<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

/**
 *  @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
interface GroupActionInterface
{
    /**
     * Returns the object class name.
     *
     * @return string
     */
    public function getObjectClassName();

    /**
     * Returns the available actions
     *
     * @return array
     */
    public function getActions();

    /**
     * Sets group action's alias with the given alias
     *
     * @param string $alias
     *
     * @return GroupActionInterface
     */
    public function setAlias($alias);

    /**
     * Returns group action's alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Executes group action with given data.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function execute(array $data);

    /**
     * Returns the group action name.
     *
     * @return string
     */
    public function getName();
}
