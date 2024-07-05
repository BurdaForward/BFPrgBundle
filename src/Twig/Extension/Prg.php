<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Twig\Extension;

use BurdaForward\BFPrgBundle\Factory\LinkOptionsFactory;
use BurdaForward\BFPrgBundle\Service\PrgService;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class Prg
 *
 * @package BurdaForward\BFPrgBundle\Twig\Extension
 */
class Prg extends AbstractExtension
{
    /**
     * Prg constructor.
     *
     * @param Environment $twigEnvironment
     */
    public function __construct(private readonly Environment $twigEnvironment)
    {
    }

    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('prg_link', [$this, 'generateLink']),
            new TwigFunction('prg_encode', [$this, 'encodeUrl']),
        ];
    }

    /**
     * @param string $submitData
     * @param string $linkTitle
     * @param array $linkOptions
     * @return string
     * @throws \Exception
     */
    public function generateLink(string $submitData, string $linkTitle, array $linkOptions = []): string
    {
        if ($submitData === '') {
            throw new \UnexpectedValueException('You have to set data to redirect to.');
        }

        $linkOptionsDto = LinkOptionsFactory::fromArray($linkOptions);

        if ($linkTitle === '' && !$linkOptionsDto->isOnlyOpenTag()) {
            throw new \UnexpectedValueException('You have to set a link title.');
        }

        $linkTemplateParameters = [
            'prg_link_class' => $linkOptionsDto->getClass(),
            'prg_link_data' => PrgService::encodeData($submitData),
            'prg_link_target' => $linkOptionsDto->getTarget()->value,
            'prg_link_title' => $linkTitle,
            'only_open_tag' => $linkOptionsDto->isOnlyOpenTag(),
        ];

        return $this->twigEnvironment->render($linkOptionsDto->getTemplate()->value, $linkTemplateParameters);
    }

    /**
     * @param string $inputData
     * @return string
     * @throws \Exception
     */
    public function encodeUrl(string $inputData): string
    {
        if ($inputData === '') {
            throw new \UnexpectedValueException('You have to set data to encode.');
        }

        return PrgService::encodeData($inputData);
    }
}
