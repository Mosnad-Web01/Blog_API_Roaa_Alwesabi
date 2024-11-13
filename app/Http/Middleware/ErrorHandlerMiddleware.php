<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class ErrorHandlerMiddleware
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
        // معالجة الأخطاء
        try {
            return $next($request);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'حدث خطأ في قاعدة البيانات.',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'فشل التحقق من البيانات.',
                'messages' => $e->validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ غير متوقع.',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle validation for incoming requests.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $rules
     * @return \Illuminate\Support\MessageBag|null
     */
    public function validate(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator); // رمي استثناء للتحقق
        }

        return null; // لا يوجد أخطاء
    }
}
