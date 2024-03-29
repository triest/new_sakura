<?php

    namespace App\Http;

    use App\Jobs\RecalculateAge;
    use Illuminate\Console\Scheduling\Schedule;
    use Illuminate\Foundation\Http\Kernel as HttpKernel;

    class Kernel extends HttpKernel
    {
        /**
         * The application's global HTTP middleware stack.
         *
         * These middleware are run during every request to your application.
         *
         * @var array
         */
        protected $middleware = [
                \App\Http\Middleware\TrustProxies::class,
                \App\Http\Middleware\CheckForMaintenanceMode::class,
                \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
                \App\Http\Middleware\TrimStrings::class,
                \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ];

        /**
         * The application's route middleware groups.
         *
         * @var array
         */
        protected $middlewareGroups = [
            'web' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                // \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \App\Http\Middleware\LastUserActivity::class,
            ],

            'api' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\LastUserActivity::class,
                'throttle:60,1',
                'bindings',
            ],
        ];

        /**
         * The application's route middleware.
         *
         * These middleware may be assigned to groups or used individually.
         *
         * @var array
         */
        protected $routeMiddleware = [
                'auth' => \App\Http\Middleware\Authenticate::class,
                'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
                'permission' => \App\Http\Middleware\Permission::class,
                'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
                'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
                'can' => \Illuminate\Auth\Middleware\Authorize::class,
                'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
                'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
                'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
                'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
                'api_token' => \App\Http\Middleware\ApiToken::class,
                'admin' => \App\Http\Middleware\admin::class,
                'not_login'=> \App\Http\Middleware\NotLogin::class,
        ];

        /**
         * The priority-sorted list of middleware.
         *
         * This forces non-global middleware to always be in the given order.
         *
         * @var array
         */
        protected $middlewarePriority = [
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\Authenticate::class,
                \Illuminate\Routing\Middleware\ThrottleRequests::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Illuminate\Auth\Middleware\Authorize::class,
        ];

        /**
         * Define the application's command schedule.
         *
         * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
         * @return void
         */
        protected function schedule(Schedule $schedule)
        {
            // $schedule->command('inspire')
            //          ->hourly();
            $schedule->job(new RecalculateAge)->timezone('Europe/Moscow')->dailyAt('03:00')->withoutOverlapping() ;
        }

    }
