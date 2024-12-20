<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidProvidedDataException extends Exception
{
    protected $code = 422;
    protected $message = 'The data provided is invalid.';

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
