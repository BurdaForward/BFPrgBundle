<?php

namespace BurdaForward\BFPrgBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class BFPrgExtension
 * @package BurdaForward\BFPrgBundle\DependencyInjection
 */
class BFPrgExtension extends Extension
{
  /**
   * {@inheritdoc}
   * @throws \Exception
   */
  public function load(array $configs, ContainerBuilder $container): void
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yml');
  }
}
