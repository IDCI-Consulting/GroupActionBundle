<?php

namespace IDCI\Bundle\GroupActionBundle\Exception;

class UndefinedGroupActionNamespaceException extends \InvalidArgumentException
{
    public function __construct($namespace)
    {
        parent::__construct(sprintf(
            'The following group action namespace "%s" is undefined.',
            $namespace
        ));
    }
}
