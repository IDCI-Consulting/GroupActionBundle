<?php

namespace IDCI\Bundle\GroupActionBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler\GroupActionCompilerPass;
use IDCI\Bundle\GroupActionBundle\DependencyInjection\Compiler\NamespaceCompilerPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class IDCIGroupActionBundle extends AbstractBundle
{
    protected string $extensionAlias = 'idci_group_action';

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->booleanNode('enable_confirmation')
                    ->defaultTrue()
                ->end()
                ->arrayNode('namespaces')
                    ->useAttributeAsKey('namespace')
                    ->arrayPrototype()
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('action_alias')->end()
                                ->scalarNode('display_label')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
        $container->parameters()->set(sprintf('%s.namespaces', $this->extensionAlias), $config['namespaces']);
        $container->parameters()->set(sprintf('%s.enable_confirmation', $this->extensionAlias), $config['enable_confirmation']);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new GroupActionCompilerPass());
        $container->addCompilerPass(new NamespaceCompilerPass());
    }
}