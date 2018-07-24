<?php

namespace IDCI\Bundle\GroupActionBundle\Exception;

class NotGuessedGroupActionException extends \InvalidArgumentException
{
    public function __construct($namespace)
    {
        parent::__construct(sprintf(
            'The group actions cannot be guessed for namespace "%s"',
            $namespace
        ));
    }
}
