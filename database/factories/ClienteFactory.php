<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
  return [
    'rif' => 'J-'.$faker->numberBetween($min = 4000000, $max = 20000000).'-'.$faker->randomDigitNot(5),
    'nombre' => $faker->company,
    'direccion' => $faker->address
  ];
});
