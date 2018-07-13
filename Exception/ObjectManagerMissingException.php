<?php

namespace IDCI\Bundle\GroupActionBundle\Exception;

use Doctrine\Common\Persistence\ObjectManager;

class ObjectManagerMissingException extends \InvalidArgumentException
{
    public function __construct($class)
    {
        parent::__construct(sprintf(
            'The ObjectManager must be set for "%s"',
            $class
        ));
    }
}
