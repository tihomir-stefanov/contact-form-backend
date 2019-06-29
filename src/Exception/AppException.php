<?php

namespace App\Exception;

use Exception;
use Throwable;

/**
 * Class AppException
 * @package App\Exception
 */
class AppException extends Exception implements AppExceptionInterface
{
    public function __construct(array $exception = [0 => ''], ?string $message = '', array $extra = [], Throwable $previous = null)
    {
        $code = key($exception);
        $data = [];
        if (!$message) {
            $message = $exception[$code];
        }

        $data['message'] = $message;
        $data['data'] = $extra;

        parent::__construct(json_encode($data), $code, $previous);
    }
}

