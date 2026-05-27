<?php

namespace IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NamespaceCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('idci.group_action.guesser')) {
            return;
        }

        $guesserDefinition = $container->getDefinition('idci.group_action.guesser');
        $namespaces = $container->getParameter('idci.group_action.namespaces');

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
