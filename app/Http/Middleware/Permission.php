<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        $user = \Auth::guard('admin')->user();
//        $currentRoute = \Route::getCurrentRoute()->getName();
//
//
//
//        if(! preg_match('/^.*ajax.*$/', $currentRoute)) { // если метод обработки не ajax
//            // Если пользователь не активен то доступ закрыт
//            if ($user->active != 1) {
//                abort(423, 'Действие вашего пользователя приостановлено или пользователь не активирован администратором');
//            }
//
//            // Если разрешение на данный роутинг нет то доступ запрещен
//            if (! $user->access($currentRoute)) {
//                abort(424, 'Разрешение на доступ к данному функционалу отсутствует, обратитесь к амдинистратору');
//            }
//        }

        return $next($request);
    }
}
