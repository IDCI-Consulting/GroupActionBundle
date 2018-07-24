<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

use IDCI\Bundle\GroupActionBundle\Action\GroupActionInterface;

interface GroupActionGuesserInterface
{
    /**
     * Guess the group action list by given namespace
     *
     * @param string $namespace
     *
     * @return array
     */
    public function guess($namespace);
}
