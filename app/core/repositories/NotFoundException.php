<?php

namespace core\repositories;


use Throwable;

class NotFoundException extends \DomainException
{
    /**
     * @var array
     */
    private $conditions = [];

    public function __construct(array $conditions, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->conditions = $conditions;
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
