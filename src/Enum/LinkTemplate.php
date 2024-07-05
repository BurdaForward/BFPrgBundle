<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Enum;

enum LinkTemplate: string
{
    case BUTTON = '@BFPrg/prg_link_button.html.twig';
    case DIV = '@BFPrg/prg_link_div.html.twig';
    case A = '@BFPrg/prg_link_a.html.twig';
    case SPAN = '@BFPrg/prg_link_span.html.twig';

    public static function fromMixed(mixed $element): self
    {
        if (!is_string($element)) {
            return self::SPAN;
        }

        return match (strtoupper($element)) {
            self::BUTTON->name => self::BUTTON,
            self::DIV->name => self::DIV,
            self::A->name => self::A,
            default => self::SPAN,
        };
    }
}
