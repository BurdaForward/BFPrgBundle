<?php

namespace BurdaForward\BFPrgBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package BurdaForward\BFPrgBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
  /**
   * {@inheritdoc}
   * @throws \Exception
   */
  public function getConfigTreeBuilder(): TreeBuilder
  {
    $tree_builder = new TreeBuilder('prg');
    $root_node = $tree_builder->root('prg');

    return $tree_builder;
  }
}
