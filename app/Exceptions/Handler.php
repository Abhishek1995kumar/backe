<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register() {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function report(Throwable $exception) {
        $this->loadError($exception);
        parent::report($exception);
    }

    public function loadError(Throwable $exception) {
        $line = $exception->getLine();
        $file = $exception->getFile();
        $message = $exception->getMessage();
        $code = $exception->getCode();
        if($exception instanceof QueryException) {
            errorLog(
                $file, $line, $message,
                $exception->getSql(), $exception->getBindings(),
                $code
            );
        }
        errorLog($file, $line, $message, '', '', $code);
    }
}
