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
    return new TreeBuilder('prg');
  }
}
