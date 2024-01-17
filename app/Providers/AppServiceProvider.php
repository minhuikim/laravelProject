<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;
        Model::shouldBeStrict(!$app->isProduction()); // 의도하지 않은 동작에 에러를 발생시켜줌
    }
}
