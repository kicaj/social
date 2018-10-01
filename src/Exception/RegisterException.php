<?php
namespace Social\Exception;

use Cake\Datasource\Exception\RecordNotFoundException;

class RegisterException extends RecordNotFoundException
{

    /**
     * @inheritdoc
     */
    public function __construct($message, $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
