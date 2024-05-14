<?php

namespace App\Http\Middleware;

use App\Exceptions\RecordConflictException;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (HttpException $e) {
            throw new RecordConflictException();
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: Response::$statusTexts[$statusCode];

            return response()->json([
                'error' => $message,
            ], $statusCode);
        } catch (Exception $e) {
            throw new RecordConflictException();
            Log::error($e); // Log the error for debugging

            return response()->json([
                'error' => 'Internal Server Error',
            ], 500);
        }
    }
}
