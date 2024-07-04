<?php

declare(strict_types=1);

namespace BurdaForward\BFPrgBundle\Service;

/**
 * Class PrgService
 * @package BurdaForward\BFPrgBundle\Service
 */
class PrgService
{
    /**
     * @param string $data
     * @return string
     */
    public static function encodeData(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * @param string $data
     * @return string
     */
    public static function decodeData(string $data): string
    {
        return base64_decode($data, true);
    }
}
