<?php

namespace BurdaForward\BFPrgBundle\Controller;

use BurdaForward\BFPrgBundle\Service\PrgService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class DefaultController
 * @package BurdaForward\BFPrgBundle\Controller
 */
class DefaultController extends Controller
{

  /** @var string $baseLocation */
  private $baseLocation;

  /** @var Router $router */
  private $router;

  /**
   * @param ContainerInterface|null $container
   * @throws \Exception
   */
  public function setContainer(ContainerInterface $container = null)
  {
    parent::setContainer($container);

    $this->router = $this->container->get('router');

    $domain = $this->container->getParameter('domain_url');
    $this->baseLocation = sprintf('//%s/', $domain);
  }

  /**
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   * @throws \Exception
   */
  public function resolveAction(Request $request) {
    $post_data = $request->request->all();
    $prgdata = array_key_exists('prgdata', $post_data) ? $post_data['prgdata'] : '';

    $location = $this->baseLocation;

    if (!empty($prgdata)) {
      $referer = $request->headers->get('referer');
      $location = $this->buildLocation($prgdata, $referer);
    }

    return new RedirectResponse($location, 302);
  }

  /**
   * @param string $prgdata
   * @param string $referer
   * @return string
   * @throws \Exception
   */
  private function buildLocation($prgdata, $referer)
  {
    $decoded_post_data = PrgService::decodeData($prgdata);

    if ($this->isExternalLocation($decoded_post_data)) {
      return $decoded_post_data;
    }

    if ($this->hasApplicationPath($decoded_post_data)) {
      return $decoded_post_data;
    }

    $cleaned_referer = str_replace(['http:', 'https:'], '', $referer);

    if (strpos($cleaned_referer, $this->baseLocation) !== FALSE) {
      return $cleaned_referer;
    }

    return $this->baseLocation;
  }

  /**
   * @param $prgdata
   * @return bool
   */
  private function isExternalLocation($prgdata)
  {
    return (substr_count($prgdata, $this->baseLocation) === 0);
  }

  /**
   * @param $decoded_post_data
   * @return array|bool
   * @throws \Exception
   */
  private function hasApplicationPath($decoded_post_data)
  {
    $url_data = parse_url($decoded_post_data);
    $url_path = array_key_exists('path', $url_data) ? $url_data['path'] : '';

    try {
      $this->router->match($url_path);
      return true;
    } catch (\Exception $exception) {
      return false;
    }
  }
}
