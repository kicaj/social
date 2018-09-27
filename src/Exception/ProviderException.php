<?php
namespace Social\Exception;

use Cake\Core\Exception\Exception;

class ProviderException extends Exception
{

    /**
     * @inheritdoc
     */
    public function __construct($message, $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
