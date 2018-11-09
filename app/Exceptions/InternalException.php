<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InternalException extends Exception
{
    protected $messageForUser;

    public function __construct(string $message, string $messageForUser = '系统内部错误', int $code = 500)
    {
        parent::__construct($message, $code);
        $this->msgForUser = $msgForUser;
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->messageForUser], $this->code);
        }

        return view('pages.error')
            ->with('code', $this->code)
            ->with('message', $this->messageForUser);
    }
}
