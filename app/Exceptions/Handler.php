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

    public function register(): void
    {
        // Model not found (e.g., Borrower::findOrFail)
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                $model = class_basename($e->getModel());

                return response()->json([
                    'status'  => 'error',
                    'message' => "{$model} not found"
                ], 404);
            }
        });

        // Route not found (bad endpoint, not a missing model)
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Resource not found'
                ], 404);
            }
        });

        // Validation errors
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Validation failed',
                    'errors'  => $e->errors()
                ], 422);
            }
        });

        // Unauthenticated
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthenticated'
                ], 401);
            }
        });

        // Generic fallback
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Server error'
                    // 'error' => $e->getMessage(), // Uncomment for debug
                ], 500);
            }
        });
    }
}
