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
     * {@inheritDoc}
     */
    public function addAction($namespace, GroupActionInterface $action)
    {
        $this->namespaces[$namespace][] = $action;

        return $this;
    }
}
