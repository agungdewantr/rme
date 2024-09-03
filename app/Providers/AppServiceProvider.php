<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        VarDumper::setHandler(function ($var) {
            $cloner = new VarCloner();
            $cloner->setMaxItems(-1); // Specifying -1 removes the limit
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

            $dumper->dump($cloner->cloneVar($var));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!$this->app->environment('local')) {
            \URL::forceScheme('https');
        }
        Model::shouldBeStrict(!app()->isProduction());

        Gate::define('report-read', function (User $user) {
            $user->load('role.permissions');
            return $user->role->permissions->where('name', 'report-read')->first() != null || $user->role->name == 'superAdmin';
        });

        Validator::extend('captcha', function($attribute, $value, $parameters, $validator) {
            return app('captcha')->verifyResponse($value);
        });

        Validator::replacer('captcha', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Captcha is incorrect.');
        });
    }
}
