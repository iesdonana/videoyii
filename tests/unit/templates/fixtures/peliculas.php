<?php

// peliculas.php file under the template path (by default @tests/unit/templates/fixtures)
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'codigo' => $faker->randomNumber(4),
    'titulo' => $faker->catchPhrase,
    'precio' => $faker->randomFloat(2, 0, 999.99),
];
