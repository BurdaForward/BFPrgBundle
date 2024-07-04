<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Enum;

enum LinkTarget: string
{
    case BLANK = '_blank';
    case SELF = '_self';
    case TOP = '_top';

    public static function fromMixed(mixed $target): self
    {
        return match ($target) {
            self::BLANK->value => self::BLANK,
            self::TOP->value => self::TOP,
            default => self::SELF,
        };
    }
}
