<?php

namespace App\Exceptions;

use Exception;

class ExceptionWithMessageForUser extends Exception
{
    protected $code = 422;

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
            'msgShouldBeShown' => true
        ], $this->code);
    }
}
