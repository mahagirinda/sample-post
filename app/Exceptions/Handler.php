<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    public function render($request, Throwable $e): Response|JsonResponse|RedirectResponse
    {
        if ($e instanceof NotFoundHttpException) {
            return redirect()->back()->with('error', 'Page Not Found');
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return redirect()->back()->with('error', 'Method Not Allowed');
        }

        if ($e instanceof AuthorizationException) {
            return redirect()->route('login')->with('error', 'You are not authorized to view this page');
        }

        return parent::render($request, $e);
    }
}
