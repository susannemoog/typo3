<?php

declare(strict_types=1);
namespace TYPO3\CMS\Extbase;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $container) {
    $container->registerForAutoconfiguration(Mvc\RequestHandlerInterface::class)->addTag('extbase.request_handler');
    $container->registerForAutoconfiguration(Mvc\Controller\ControllerInterface::class)->addTag('extbase.controller');
    $container->registerForAutoconfiguration(Mvc\Controller\ActionController::class)->addTag('extbase.action_controller');

    $container->addCompilerPass(new class() implements CompilerPassInterface {
        public function process(ContainerBuilder $container): void
        {
            foreach ($container->findTaggedServiceIds('extbase.request_handler') as $id => $tags) {
                $container->findDefinition($id)->setPublic(true);
            }
            foreach ($container->findTaggedServiceIds('extbase.controller') as $id => $tags) {
                $container->findDefinition($id)->setPublic(true);
            }
            foreach ($container->findTaggedServiceIds('extbase.action_controller') as $id => $tags) {
                $container->findDefinition($id)->setShared(false);
            }
        }
    });
};
