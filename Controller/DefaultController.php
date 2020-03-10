<?php

namespace BurdaForward\BFPrgBundle\Controller;

use BurdaForward\BFPrgBundle\Service\PrgService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class DefaultController
 * @package BurdaForward\BFPrgBundle\Controller
 */
class DefaultController extends AbstractController
{

    /** @var string $baseLocation */
    private $baseLocation;

    /** @var Router $router */
    private $router;

    /**
     * @param \Psr\Container\ContainerInterface $container
     * @return \Psr\Container\ContainerInterface|null
     */
    public function setContainer(\Psr\Container\ContainerInterface $container): ?\Psr\Container\ContainerInterface
    {
        $previous = parent::setContainer($container);

        $this->router = $this->container->get('router');

        $domain = $this->router->getContext()->getBaseUrl();
        $this->baseLocation = sprintf('//%s/', $domain);

        return $previous;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function resolveAction(Request $request): RedirectResponse
    {
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
    private function buildLocation($prgdata, $referer): string
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
    private function isExternalLocation($prgdata): bool
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
