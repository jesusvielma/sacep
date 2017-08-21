<?php

namespace sacep\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use sacep\Acta;
use sacep\Material;
use sacep\Evaluacion;
use sacep\Policies\ActaPolicy;
use sacep\Policies\MaterialPolicy;
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
        Evaluacion::class => EvaluacionPolicy::class,
        Material::class => MaterialPolicy::class,
        Acta::class => ActaPolicy::class,
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

        Gate::define('procesar',function ($usuario)
        {
            return $usuario->nivel == 'th';
        });

        Gate::define('ver_ev',function ($usuario)
        {
            return $usuario->nivel != 'admin';
        });


    }
}
