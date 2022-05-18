<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use App\Traits\RestExceptionHandlerTrait;
use App\Traits\RestTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    use RestExceptionHandlerTrait;
    use RestTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isApiCallFrom($request)) {
            // $retval = $this->getJsonResponseForException($request, $exception);
            return $this->renderJson($exception);
        }

        parent::render($request, $exception);
    }

    /**
     * Render an exception into an REST API response.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function renderJson(Throwable $exception): JsonResponse
    {
        switch (true) {
            case $exception instanceof MethodNotAllowedHttpException:
                $message = 'The specified method for the request is invalid.';
                $retval = $this->respondError($message, Response::HTTP_METHOD_NOT_ALLOWED);

                break;
            case $exception instanceof NotFoundHttpException:
                $message = 'The specified URL cannot be found.';
                $retval = $this->respondError($message, Response::HTTP_NOT_FOUND);

                break;
            case $exception instanceof HttpException:
                /** @var HttpException $exception */
                $retval = $this->respondError($exception->getMessage(), $exception->getStatusCode());

                break;
            case $exception instanceof ValidationException:
                /** @var ValidationException $exception */
                $retval = $this->respondError($exception->getMessage(), $exception->status, $exception->errors());

                break;
            default:
                $message = 'Unexpected Exception. Try later.';
                $retval = $this->respondError($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $retval;
    }
}
