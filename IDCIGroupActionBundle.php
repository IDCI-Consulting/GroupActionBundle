<?php

namespace IDCI\Bundle\GroupActionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler\GroupActionCompilerPass;

class IDCIGroupActionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GroupActionCompilerPass());
    }
}
