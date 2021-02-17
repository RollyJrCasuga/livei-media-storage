<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

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
        Builder::macro('whereLike', function($attributes, string $search) {
            foreach(Arr::wrap($attributes) as $attribute) {
                $this->orWhere($attribute, 'LIKE', "%{$search}%");
            }
            return $this;
        });
        Paginator::useBootstrap();
    }
}
