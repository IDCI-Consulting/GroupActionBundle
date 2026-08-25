<?php

namespace IDCI\Bundle\GroupActionBundle;

use IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler\GroupActionCompilerPass;
use IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler\NamespaceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IDCIGroupActionBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GroupActionCompilerPass());
        $container->addCompilerPass(new NamespaceCompilerPass());
    }
}
