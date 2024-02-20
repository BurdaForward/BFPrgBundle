<?php

namespace BurdaForward\BFPrgBundle\Twig\Extension;

use BurdaForward\BFPrgBundle\Service\PrgService;
use Symfony\Component\DependencyInjection\ContainerInterface;
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

    /** @var Environment $twigEnvironment */
    private $twigEnvironment;

    /**
     * Prg constructor.
     *
     * @param ContainerInterface $container
     * @throws \Exception
     */
    public function __construct(ContainerInterface $container)
    {
        $this->twigEnvironment = $container->get('twig');
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('prg_link', [$this, 'generateLink']),
            new TwigFunction('prg_encode', [$this, 'encodeUrl']),
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

        $boolOnlyOpenTag = $this->readOpenTagOnlyOption($linkOptions);

        if (empty($linkTitle) && !$boolOnlyOpenTag) {
            throw new \UnexpectedValueException('You have to set a link title.');
        }

        $link_template_parameters = [
            'prg_link_class' => $this->readClassOption($linkOptions),
            'prg_link_data' => PrgService::encodeData($submitData),
            'prg_link_target' => $this->readTargetOption($linkOptions),
            'prg_link_title' => $linkTitle,
            'only_open_tag' => $boolOnlyOpenTag,
        ];

        return $this->twigEnvironment->render(self::getLinkTemplate($linkOptions), $link_template_parameters);
    }

    /**
     * @param $inputData
     * @return string
     * @throws \Exception
     */
    public function encodeUrl($inputData): string
    {
        if (empty($inputData)) {
            throw new \UnexpectedValueException('You have to set data to encode.');
        }

        return PrgService::encodeData($inputData);
    }

    /**
     * @param array $linkOptions
     * @return string
     */
    private static function getLinkTemplate(array $linkOptions): string
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

                case 'a':
                    $link_template = '@BFPrg/prg_link_a.html.twig';
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

    /**
     * @param array $linkOptions
     * @return bool
     */
    protected function readOpenTagOnlyOption(array $linkOptions): bool
    {
        if (array_key_exists('only_open_tag', $linkOptions)) {
            $open_tag_value = $linkOptions['only_open_tag'];

            if (!empty($open_tag_value) && is_bool($open_tag_value)) {
                return $open_tag_value;
            }
        }

        return false;
    }
}
