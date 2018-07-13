<?php

namespace IDCI\Bundle\GroupActionBundle\Exception;

class ObjectManagerMissingException extends \InvalidArgumentException
{
    public function __construct($namespace)
    {
        parent::__construct(sprintf(
            'The group actions cannot be guessed for namspace "%s"',
            $namespace
        ));
    }
}
