<?php

namespace BurdaForward\BFPrgBundle\Service;

/**
 * Class PrgService
 * @package BurdaForward\BFPrgBundle\Service
 */
class PrgService {

  /**
   * @param $data
   * @return string
   * @throws \Exception
   */
  public static function encodeData($data)
  {
    if (!is_string($data)) {
      throw new \UnexpectedValueException('Given argument value have to be a string.');
    }

    return base64_encode($data);
  }

  /**
   * @param $data
   * @return string
   * @throws \Exception
   */
  public static function decodeData($data) {

    if (!is_string($data)) {
      throw new \UnexpectedValueException('Given argument value have to be a string.');
    }

    return base64_decode($data, TRUE);
  }

}
