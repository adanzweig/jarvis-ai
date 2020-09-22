<?php

namespace xzaero\Netatmo\Exceptions;

class NAInternalErrorType extends NAClientException
{
    function __construct($message)
    {
        parent::__construct(0, $message, INTERNAL_ERROR_TYPE);
    }
}

?>
