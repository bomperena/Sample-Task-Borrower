<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [];

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            //Model not found (Borrower not found)
            if ($e instanceof ModelNotFoundException) {
                $model = class_basename($e->getModel());
                return response()->json([
                    'status'  => 'error',
                    'message' => "{$model} not found"
                ], 404);
            }

            //Route not found (wrong endpoint)
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Resource not found'
                ], 404);
            }

            //Validation errors
            if ($e instanceof ValidationException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Validation failed',
                    'errors'  => $e->errors()
                ], 422);
            }

            //Unauthenticated
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }

            //Catch-all (server error)
            return response()->json([
                'status'  => 'error',
                'message' => 'Server error'
            ], 500);
        }

        return parent::render($request, $e);
    }
}
