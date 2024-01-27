<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson() === false) {
            return parent::render($request, $e);
        }

        $code = $this->parseExceptionCode($e);
        $message = $this->parseExceptionMessage($e, $code);
        $payload = $this->parseExceptionPayload($e);

        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
            'payload' => $payload,
        ], $code);
    }

    /**
     * Parse the exception code.
     */
    protected function parseExceptionCode(Throwable $e): int
    {
        if ($e instanceof HttpException) {
            return $e->getStatusCode();
        }

        if ($e instanceof ModelNotFoundException) {
            return 404;
        }

        if ($e instanceof ValidationException) {
            return $e->status;
        }

        return 400;
    }

    /**
     * Parse the exception message.
     */
    protected function parseExceptionMessage(Throwable $e, int $code): string
    {
        if ($e instanceof HttpException && $e->getMessage() !== '') {
            return $e->getMessage();
        }

        if ($e instanceof ValidationException) {
            return $e->getMessage();
        }

        return $this->getHttpMessage($code);
    }

    /**
     * Get the HTTP status message based on the status code.
     */
    protected function getHttpMessage(int $status): string
    {
        return match ($status) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Too Early',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            451 => 'Unavailable For Legal Reasons',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            default => 'Something went wrong',
        };
    }

    /**
     * Parse the exception payload.
     *
     * @return array<string, mixed>
     */
    protected function parseExceptionPayload(Throwable $e): array
    {
        if ($e instanceof ValidationException) {
            return $this->getValidationErrors($e);
        }

        if (config('app.debug', false) === true && config('app.env', 'production') !== 'production') {
            return $this->getDebugErrors($e);
        }

        return [];
    }

    /**
     * Get the validation errors.
     *
     * @return array<string, array<string>>
     */
    protected function getValidationErrors(ValidationException $e): array
    {
        return $e->errors();
    }

    /**
     * Get the debug errors.
     *
     * @return array<string, mixed>
     */
    protected function getDebugErrors(Throwable $e): array
    {
        return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ],
        ];
    }
}
