<?php

namespace App\Exceptions;

use App\Support\Api\ApiResponse;
use BadMethodCallException;
use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    private mixed $code = 400;

    private array $body = [];

    private string $info = ' Handler Exception ';

    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse {

        return $request->expectsJson()
            ? self::apiResponse($this->code, $exception->getMessage(), info: 'AuthenticationException '.$this->info.$exception->getMessage())
            : redirect()->guest($exception->redirectTo());
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {

            if ($exception instanceof ValidationException) {
                $errors = $exception->errors();
                $message = '';
                foreach ($errors as $key => $error) {
                    $this->body[$key] = $message = $error[0];
                }

                return self::apiResponse($this->code, $message, $this->body, info: 'ValidationException '.
                    $this->info.$exception->getMessage());
            }

            if ($exception instanceof NotFoundHttpException) {
                return self::apiResponse($this->code, $exception->getMessage(), info: 'NotFoundHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof AccessDeniedHttpException) {

                return self::apiResponse($this->code, $exception->getMessage(), info: 'AccessDeniedHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof TypeError) {

                return self::apiResponse($this->code, $exception->getMessage(), info: 'AccessDeniedHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof ErrorException) {
                return self::apiResponse($this->code, $exception->getMessage(), info: 'ErrorException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof InvalidArgumentException) {
                return self::apiResponse($this->code, $exception->getMessage(), info: 'InvalidArgumentException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return self::apiResponse($this->code, $exception->getMessage(), info: 'MethodNotAllowedHttpException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof BadMethodCallException) {
                return self::apiResponse($this->code, $exception->getMessage(), info: 'BadMethodCallException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }

            if ($exception instanceof AuthenticationException) {
                return self::apiResponse($this->code, t_('Please login first'), info: 'AuthenticationException '.$this->info.$exception->getMessage());
            }

            if ($exception instanceof ModelNotFoundException) {

                return self::apiResponse($this->code, t_('There are no results for your search query'), info: 'ModelNotFoundException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
            // Custom QueryException render.
            if ($exception instanceof QueryException) {
                if ($exception->getCode() == 23000) {
                    return self::apiResponse($this->code, 'You cannot erase data because it is connected to other data',
                        info: 'QueryException '.
                        $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
                }

                return self::apiResponse($this->code, $exception->getMessage(), info: 'QueryException '.
                    $this->info.$exception->getMessage().' File: '.$exception->getFile().' Line: '.$exception->getLine());
            }
        } elseif (strpos(request()->url(), '/') == false &&
            ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException)) {
            return response()->view('Common::404', ['type' => 404]);
        }

        return parent::render($request, $exception);
    }

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
}
