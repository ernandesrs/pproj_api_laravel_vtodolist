<?php

namespace App\Exceptions;

use Exception;

class UserHasBeenTakenException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'User has been taken.';

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->message,
        ], 400);
    }
}
