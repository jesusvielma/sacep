<?php

namespace sacep\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use sacep\Empleado;
use sacep\Policies\EvaluacionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'sacep\Model' => 'sacep\Policies\ModelPolicy',
        //'sacep\Evaluacion' => 'sacep\Policies\EvaluacionPolicy',
        Empleado::class => EvaluacionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('config', function ($usuario)
        {
            return $usuario->nivel == 'th';
        });

        Gate::define('admin', function ($usuario)
        {
            return $usuario->nivel == 'admin';
        });
    }
}
