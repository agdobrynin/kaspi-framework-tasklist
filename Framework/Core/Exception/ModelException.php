<?php

namespace Core\Exception;

use Core\Throwable;

class ModelException extends \Exception
{
    public function __construct(array $errorInfo, Throwable $previous = null)
    {
        parent::__construct('Ошибка SQL: '.$errorInfo[2], $errorInfo[1], $previous);
    }
}
