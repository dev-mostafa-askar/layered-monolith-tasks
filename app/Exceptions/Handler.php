<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\ConvertsExceptions;
use Flugg\Responder\Exceptions\Http\UnauthenticatedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ConvertsExceptions;
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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return $this->formatResponse('unauthorized', "This action is unauthorized", 401);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->formatResponse('authentication_error', "Unauthenticated", 401);
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof  NotFoundHttpException) {
            return $this->formatResponse('not_found', $exception->getMessage() ? $exception->getMessage() : 'page not found', 404);
        }

        if ($exception instanceof HttpApiValidationException) {
            return $this->renderResponse($exception);
        }

        if ($exception instanceof UnauthenticatedException) {
            return $this->formatResponse('unauthenticated', $exception->getMessage() ? $exception->getMessage() : 'Unauthenticated', 403);
        }

        if ($exception instanceof BadRequestHttpException) {
            return $this->formatResponse('bad_request', $exception->getMessage() ? $exception->getMessage() : 'Bad requst', 400);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return $this->formatResponse('too_many_requests', $exception->getMessage() ? $exception->getMessage() : 'Too many requests', 429);
        }

        if ($exception instanceof CantDeleteException) {
            return $this->formatResponse('cant_delete', $exception->getMessage() ? $exception->getMessage() : 'Cant Delete this item', 400);
        }

        if ($exception instanceof RuntimeException) {
            return $this->formatResponse('runtime_error', $exception->getMessage() ? $exception->getMessage() : 'Runtime Error', 500);
        }

        return parent::render($request, $exception);
    }

    protected function formatResponse($code, $message, $statusCode = 500)
    {
        return responder()->error($code, $message)->respond($statusCode);
    }
}
