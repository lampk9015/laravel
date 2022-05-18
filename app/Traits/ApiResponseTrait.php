<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponseTrait
{
    /**
     * Return a success JSON response.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data, string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        if (! $message) {
            $message = Response::$statusTexts[$statusCode];
        }

        return new JsonResponse([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError(string $message = null, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, $data = null)
    {
        if (! $message) {
            $message = Response::$statusTexts[$statusCode];
        }

        return new JsonResponse([
            'status' => 'Error',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Response with status code 200.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($data, string $message = null): JsonResponse
    {
        return $this->respondSuccess($data, $message);
    }

    /**
     * Response with status code 201.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data, string $message = null): JsonResponse
    {
        return $this->respondSuccess($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Response with status code 204.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNoContent(): JsonResponse
    {
        return $this->respondSuccess([], null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Response with status code 400.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest($data, string $message = null): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_BAD_REQUEST, $data);
    }

    /**
     * Response with status code 401.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnauthorized($data, string $message = null): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_UNAUTHORIZED, $data);
    }

    /**
     * Response with status code 404.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($data, string $message = null): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_NOT_FOUND, $data);
    }

    /**
     * Response with status code 409.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondConflict($data, string $message = null): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_CONFLICT, $data);
    }

    /**
     * Response with status code 422.
     *
     * @param  array|Arrayable|JsonSerializable|null  $data
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnprocessable($data, string $message = null): JsonResponse
    {
        return $this->respondError($message, Response::HTTP_UNPROCESSABLE_ENTITY, $data);
    }
}
