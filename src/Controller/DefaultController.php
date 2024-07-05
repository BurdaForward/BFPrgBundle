<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Controller;

use BurdaForward\BFPrgBundle\Service\PrgService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DefaultController
 * @package BurdaForward\BFPrgBundle\Controller
 */
class DefaultController extends AbstractController
{
    private string $baseLocation;

    public function __construct(
        private readonly RouterInterface $router
    ) {
        $domain = $this->router->getContext()->getBaseUrl();
        $this->baseLocation = sprintf('//%s/', $domain);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function resolveAction(Request $request): RedirectResponse
    {
        $post_data = $request->request->all();
        $prgData = $post_data['prgdata'] ?? '';

        $location = $this->baseLocation;

        if (!empty($prgData)) {
            $referer = $request->headers->get('referer');
            $location = $this->buildLocation($prgData, $referer);
        }

        return new RedirectResponse($location, 302);
    }

    /**
     * @param string $prgData
     * @param string $referer
     * @return string
     * @throws \Exception
     */
    private function buildLocation(string $prgData, string $referer): string
    {
        $decodedPostData = PrgService::decodeData($prgData);

        if ($this->isExternalLocation($decodedPostData)) {
            return $decodedPostData;
        }

        if ($this->hasApplicationPath($decodedPostData)) {
            return $decodedPostData;
        }

        $cleanedReferer = str_replace(['http:', 'https:'], '', $referer);

        if (str_contains($cleanedReferer, $this->baseLocation)) {
            return $cleanedReferer;
        }

        return $this->baseLocation;
    }

    /**
     * @param string $prgData
     * @return bool
     */
    private function isExternalLocation(string $prgData): bool
    {
        return !str_contains($prgData, $this->baseLocation);
    }

    /**
     * @param string $decodedPostData
     * @return bool
     */
    private function hasApplicationPath(string $decodedPostData): bool
    {
        $urlData = parse_url($decodedPostData);
        $urlPath = $urlData['path'] ?? '';

        try {
            $this->router->match($urlPath);

            return true;
        } catch (\Exception) {
            return false;
        }
    }
}
