<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use BadMethodCallException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;
    
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        
        $response = $this->handleException($request, $exception);

        app(CorsService::class)->addActualRequestHeaders($response, $request);

        return $response;
    }

    public function handleException($request, Throwable $exception)
    {

        // if ($exception instanceof BadMethodCallException) {
        //     return $this->errorResponse("La solicitud contiene sintaxis err??nea", 404);
        // }

        if ($exception instanceof ValidationException) {
            $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException) {
			$model = strtolower(class_basename($exception->getModel()));
			return $this->errorResponse("No existe ninguna instancia de {$model} con el id especificado", 404);
        }
        
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
			return $this->errorResponse("No posee permisos para ejecutar esta acci??n", 403);
        }
        
        if ($exception instanceof NotFoundHttpException) {
			return $this->errorResponse("No se encontro la URL especificada", 404);
        }
        
        if ($exception instanceof MethodNotAllowedHttpException) {
			return $this->errorResponse('El m??todo especificado en la solicitud no es v??lido', 405);
        }
        
        if ($exception instanceof HttpException) {
			return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        
        if ($exception instanceof QueryException) {
			$codigo = $exception->errorInfo[1];

			if ($codigo == 1451) {
				return $this->errorResponse('No se puede eliminar de forma permamente el recurso porque est?? relacionado con alg??n otro.', 409);
			// } else {
            //     return $this->errorResponse('Falla inesperada en BD, Intente luego', 409);
            }
        }

        if ($exception instanceof TokenMismatchException) {
			return redirect()->back()->withInput($request->input());
		}

        if (config('app.debug')) {
			return parent::render($request, $exception);
		}
        
        return $this->errorResponse('Falla inesperada. Intente luego', 500);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request) 
	{
		$errors = $e->validator->errors()->getMessages();

		if ($this->isFrontend($request)) {
			return $request->ajax() ? response()->json($errors, 422) : redirect()
			->back()
			->withInput($request->input())
			->withErrors($errors);
		}

		return $this->errorResponse($errors, 422);

    }
    
    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontend($request)) {
			return redirect()->guest('login');
        }
        
        return $this->errorResponse('No Autenticado', 401);
    }

    private function isFrontend($request)
	{
		return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
	}
}
