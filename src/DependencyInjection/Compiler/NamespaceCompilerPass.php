<?php

namespace IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NamespaceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('idci_group_action.guesser')) {
            return;
        }

        $guesserDefinition = $container->getDefinition('idci_group_action.guesser');
        $namespaces = $container->getParameter('idci_group_action.namespaces');

        foreach ($namespaces as $namespace => $actions) {
            foreach ($actions as $action) {
                $guesserDefinition->addMethodCall(
                    'addAction',
                    array($namespace, $action)
                );

            }
        }
    }
}
