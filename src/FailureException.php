<?php

namespace Liamja\Cex;

use GuzzleHttp\Exception\ClientException;
use Throwable;

class FailureException extends \RuntimeException
{
    /** @var string[] */
    private $moreInfo;

    public function __construct(
        string $message = '',
        int $code = 0,
        array $moreInfo = [],
        ClientException $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->moreInfo = $moreInfo;
    }

    public function getMoreInfo(): array
    {
        return $this->moreInfo;
    }
}
