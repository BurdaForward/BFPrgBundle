<?php

namespace BurdaForward\BFPrgBundle\Twig\Extension;

use BurdaForward\BFPrgBundle\Service\PrgService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Prg
 *
 * @package BurdaForward\BFPrgBundle\Twig\Extension
 */
class Prg extends \Twig_Extension
{

  /** @var  \Twig_Environment $twigEnvironment */
  private $twigEnvironment;

  /**
   * Prg constructor.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @throws \Exception
   */
  public function __construct(ContainerInterface $container)
  {
    $this->twigEnvironment = $container->get('twig');
  }

  /**
   * @return array
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('prg_link', [$this, 'generateLink']),
    ];
  }

  /**
   * @param $submitData
   * @param $linkTitle
   * @param array $linkOptions
   * @return mixed|string
   * @throws \Exception
   */
  public function generateLink($submitData, $linkTitle, array $linkOptions = [])
  {
    if (empty($submitData)) {
      throw new \UnexpectedValueException('You have to set data to redirect to.');
    }

    if (empty($linkTitle)) {
      throw new \UnexpectedValueException('You have to set a link title.');
    }

    $link_template_parameters = [
      'prg_link_class' => $this->readClassOption($linkOptions),
      'prg_link_data'  => PrgService::encodeData($submitData),
      'prg_link_target' => $this->readTargetOption($linkOptions),
      'prg_link_title' => $linkTitle,
    ];

    return $this->twigEnvironment->render(self::getLinkTemplate($linkOptions), $link_template_parameters);
  }

  /**
   * @param array $linkOptions
   * @return string
   */
  private static function getLinkTemplate(array $linkOptions)
  {
    $link_template = '@BFPrg/prg_link_span.html.twig';

    if (array_key_exists('element', $linkOptions)) {
      $element_value = $linkOptions['element'];

      switch ($element_value) {
        case 'button':
          $link_template = '@BFPrg/prg_link_button.html.twig';
          break;

        case 'div':
          $link_template = '@BFPrg/prg_link_div.html.twig';
          break;

        default:
          $link_template = '@BFPrg/prg_link_span.html.twig';
          break;
      }
    }

    return $link_template;
  }

  /**
   * @param array $linkOptions
   * @return mixed|string
   */
  private function readClassOption(array $linkOptions)
  {
    if (array_key_exists('class', $linkOptions)) {
      $class_value = $linkOptions['class'];

      if (!empty($class_value) && is_string($class_value)) {
        return $class_value;
      }
    }

    return '';
  }

  /**
   * @param array $linkOptions
   * @return mixed|string
   */
  private function readTargetOption(array $linkOptions)
  {
    if (array_key_exists('target', $linkOptions)) {
      $target_value = $linkOptions['target'];

      if (!empty($target_value) && is_string($target_value) && in_array($target_value, ['_self', '_blank', '_top'])) {
        return $target_value;
      }
    }

    return '_self';
  }
}
