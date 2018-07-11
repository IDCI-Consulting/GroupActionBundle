<?php

namespace IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class GroupActionCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('idci.group_action.registry')) {
            return;
        }

        $registryDefinition = $container->getDefinition('idci.group_action.registry');

        foreach ($container->findTaggedServiceIds('idci.group_action') as $id => $tags) {
            $serviceDefinition = $container->findDefinition($id);

            $registryDefinition->addMethodCall(
                'setGroupAction',
                array($serviceDefinition->getClass(), new Reference($id))
            );
        }
    }
}
