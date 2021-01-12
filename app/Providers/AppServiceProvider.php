<?php

namespace App\Providers;

use App\Models\Lk\User;
use App\Observers\UserObserver;
use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('ucfirst', function ($expression) {
            return "<?php echo mb_strtoupper(mb_substr({$expression}, 0, 1)) . mb_substr({$expression}, 1); ?>";
        });
        User::observe(UserObserver::class);

    }
}
