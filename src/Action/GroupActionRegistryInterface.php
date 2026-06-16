<?php

namespace IDCI\Bundle\GroupActionBundle\Action;

interface GroupActionRegistryInterface
{
    public function setAction(string $alias, GroupActionInterface $groupAction): self;

    public function getAction(?string $alias): GroupActionInterface;

    public function hasAction(string $alias): bool;
}
