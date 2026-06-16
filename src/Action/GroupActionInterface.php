<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

interface GroupActionInterface
{
    public function setAlias(string $alias): self;

    public function getAlias(): string;

    public function execute(array $data): mixed;
}
