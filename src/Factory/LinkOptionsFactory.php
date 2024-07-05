<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Factory;

use BurdaForward\BFPrgBundle\Dto\LinkOptions;
use BurdaForward\BFPrgBundle\Enum\LinkTarget;
use BurdaForward\BFPrgBundle\Enum\LinkTemplate;

class LinkOptionsFactory
{
    public static function fromArray(array $linkOptions): LinkOptions
    {
        return new LinkOptions(
            class: self::readClassOption($linkOptions['class'] ?? ''),
            target: LinkTarget::fromMixed($linkOptions['target'] ?? ''),
            template: LinkTemplate::fromMixed($linkOptions['element'] ?? ''),
            onlyOpenTag: (bool) ($linkOptions['only_open_tag'] ?? false)
        );
    }

    private static function readClassOption(mixed $classValue): string
    {
        if (!is_string($classValue)) {
            return '';
        }

        return $classValue;
    }
}
