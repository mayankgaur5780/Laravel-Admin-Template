<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\PayloadException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->locale) {
            // Set App Language
            \App::setLocale($request->locale);
        }
       
        $message = new \stdClass;
        $message->message = __('messages.invalid_data');
        if ($request->is('api/*')) {
            if ($exception instanceof HttpResponseException) {
                $message->errors = [
                    'error' => [$exception->getMessage()],
                ];
                return response()->json($message, $exception->getStatusCode());
            }

            if ($exception instanceof ThrottleRequestsException) {

                $message->errors = [
                    'error' => [$exception->getMessage()],
                ];
                return response()->json($message, $exception->getStatusCode());
            }

            if ($exception instanceof InvalidSignatureException) {
                $message->errors = [
                    'error' => [$exception->getMessage()],
                ];
                return response()->json($message, $exception->getStatusCode());
            }

            if ($exception instanceof UrlGenerationException) {
                $message->errors = [
                    'error' => [$exception->getMessage()],
                ];
                return response()->json($message, $exception->getStatusCode());
            }

            if ($exception instanceof NotFoundHttpException) {
                $message->errors = [
                    'error' => [__('messages.not_found_http_exception')],
                ];
                return response()->json($message, $exception->getStatusCode());
            }
            if ($exception instanceof InvalidClaimException) {
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_invalid_claim_exception')],
                ];
                return response()->json($message, 422);
            }

            if ($exception instanceof PayloadException) {
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_payload_factory')],
                ];
                return response()->json($message, 422);
            }

            if ($exception instanceof TokenBlacklistedException) {
                $message->jwt_blacklisted = 1;
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_blacklisted')],
                ];
                return response()->json($message, 401);
            }

            if ($exception instanceof TokenExpiredException) {
                $message->jwt_expired = 1;
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_expired')],
                ];
                return response()->json($message, 401);
            }

            if ($exception instanceof TokenInvalidException) {
                $message->jwt_expired = 1;
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_invalid')],
                ];
                return response()->json($message, 401);
            }

            if ($exception instanceof UserNotDefinedException) {
                $message->errors = [
                    'jwt_token' => [__('messages.jwt_user_not_defined_exception')],
                ];
                return response()->json($message, 422);
            }

            if ($exception instanceof JWTException) {
                $message->errors = [
                    'jwt_token' => [$exception->getMessage()],
                ];
                return response()->json($message, 401);
            }
        }
        
        if ($exception instanceof FileException) {
            $message->errors = [
                'file' => [$exception->getMessage()],
            ];
            return response()->json($message, 401);
        }

        if ($exception instanceof PostTooLargeException) {
            $message->errors = [
                'error' => [__('messages.post_too_large_exception')],
            ];
            return response()->json($message, $exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
