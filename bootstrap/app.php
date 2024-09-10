<?php

use App\Exceptions\ApiBaseException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->web(append: [
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->api(append: [
            SubstituteBindings::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'telescope/*',
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ApiBaseException $exception, Request $request) {
            if ($request->wantsJson()) {
                return ResponseConverter::convert(
                    ResponseUtil::builder()->setMessage($exception->getMessage())
                        ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
                        ->setAction($exception->getAction())
                        ->setData($exception->getBody())
                );
            }
        });
    })->create();
