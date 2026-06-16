<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

use IDCI\Bundle\GroupActionBundle\Exception\UndefinedGroupActionNamespaceException;

class GroupActionGuesser implements GroupActionGuesserInterface
{
    private array $namespaces = [];

    public function guess(string $namespace): array
    {
        if (!array_key_exists($namespace, $this->namespaces)) {
            throw new UndefinedGroupActionNamespaceException($namespace);
        }

        return $this->namespaces[$namespace];
    }

    public function addAction(string$namespace, array $actionConfiguration): self
    {
        $this->namespaces[$namespace][] = $actionConfiguration;

        return $this;
    }
}
