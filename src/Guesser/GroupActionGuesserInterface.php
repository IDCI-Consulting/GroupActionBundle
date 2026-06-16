<?php

namespace IDCI\Bundle\GroupActionBundle\Guesser;

interface GroupActionGuesserInterface
{
    public function guess(string $namespace): array;
}
