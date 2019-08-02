<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

use IDCI\Bundle\GroupActionBundle\Exception\UndefinedGroupActionNamespaceException;

class GroupActionGuesser implements GroupActionGuesserInterface
{
    /**
     * @var array
     */
    private $namespaces = array();

    /**
     * {@inheritdoc}
     */
    public function guess($namespace)
    {
        if (!array_key_exists($namespace, $this->namespaces)) {
            throw new UndefinedGroupActionNamespaceException($namespace);
        }

        return $this->namespaces[$namespace];
    }

    /**
     * Add group action to the given namespace.
     *
     * @param string $namespace
     * @param array $actionConfiguration
     *
     * @return GroupActionGuesser
     */
    public function addAction($namespace, $actionConfiguration)
    {
        $this->namespaces[$namespace][] = $actionConfiguration;

        return $this;
    }
}
