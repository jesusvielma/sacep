<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
/**$factory->define(sacep\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});*/

$factory->define(sacep\Empleado::class,function (Faker\Generator $faker)
{
    static $id_usuario;
    return [
        'cedula_empleado' => $faker->unique()->numberBetween('5000000','30000000'),
        'nombre_completo' => $faker->name,
        'fecha_ingreso'   => $faker->dateTimeBetween('2005-01-01','now'),
        'fecha_nacimiento'=> $faker->dateTimeBetween('1930-01-01','1999-12-31'),
        'estado'          => 'activo',
        'id_usuario'      => $id_usuario ?: $id_usuario = NULL
    ];
});
