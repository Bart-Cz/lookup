<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class LookupApiException extends Exception
{
    protected $code = 500;
    protected $message = 'There was a problem retrieving the data';

    /**
     * @param string|null $message
     * @param int|null $code
     */
    public function __construct(?string $message = null, ?int $code = null)
    {
        $message = $message ?? $this->message;
        $code = $code ?? $this->code;

        parent::__construct($message, $code);
    }
}
