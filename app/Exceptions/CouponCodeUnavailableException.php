<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class CouponCodeUnavailableException extends Exception
{
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $this->message], $this->code);
        }

        return view('pages.error')
            ->with('code', $this->code)
            ->with('message', $this->message);
    }
}
