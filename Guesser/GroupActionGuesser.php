<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

use IDCI\Bundle\GroupActionBundle\Action\GroupActionInterface;
use IDCI\Bundle\GroupActionBundle\Exception\NotGuessedGroupActionException;

class GroupActionGuesser implements GroupActionGuesserInterface
{
    /**
     * @var array
     */
    private $namespaces = array();

    /**
     * {@inheritDoc}
     */
    public function guess($namespace)
    {
        if (!array_key_exists($namespace, $this->namespaces)) {
            throw new NotGuessedGroupActionException($namespace);
        }

        return $this->namespaces[$namespace];
    }

    /**
     * Add group action alias to the given namespace.
     *
     * @param string $namespace
     * @param string $actionAlias
     *
     * @return GroupActionGuesser
     */
    public function addActionAlias($namespace, $actionAlias)
    {
        $this->namespaces[$namespace][] = $actionAlias;

        return $this;
    }
}
