<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    private static string $NotFoundHttpExceptionMessage = 'Contact not found.';

    private static string $QueryExceptionMessage = 'Contact already exists.';

    private static string $ModelNotFoundExceptionMessage = 'Contacts do not exist';

    private static string $MethodNotAllowedHttpExceptionMessage = 'Your contacts request is not valid';


    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            Log::error($e->getMessage());
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => self::$MethodNotAllowedHttpExceptionMessage
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            Log::error($e->getMessage());
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => self::$NotFoundHttpExceptionMessage
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            Log::error($e->getMessage());
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => self::$ModelNotFoundExceptionMessage
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $this->renderable(function (QueryException $e, $request) {
            Log::error($e->getMessage());
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => self::$QueryExceptionMessage
                ], Response::HTTP_NOT_FOUND);
            }
        });
    }
}
