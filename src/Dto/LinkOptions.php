<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Dto;

use BurdaForward\BFPrgBundle\Enum\LinkTarget;
use BurdaForward\BFPrgBundle\Enum\LinkTemplate;

class LinkOptions
{
    public function __construct(
        private readonly string $class,
        private readonly LinkTarget $target,
        private readonly LinkTemplate $template,
        private readonly bool $onlyOpenTag
    ) {
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getTarget(): LinkTarget
    {
        return $this->target;
    }

    public function getTemplate(): LinkTemplate
    {
        return $this->template;
    }

    public function isOnlyOpenTag(): bool
    {
        return $this->onlyOpenTag;
    }
}
