<?php

// socios.php file under the template path (by default @tests/unit/templates/fixtures)
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'numero' => $faker->randomNumber(6),
    'nombre' => $faker->name,
    'direccion' => $faker->address,
    'telefono' => $faker->randomNumber(9),
];

