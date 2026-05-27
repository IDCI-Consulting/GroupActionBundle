<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

interface GroupActionGuesserInterface
{
    /**
     * Guess the group action list by given namespace.
     *
     * @param string $namespace
     *
     * @return array
     */
    public function guess($namespace);
}
