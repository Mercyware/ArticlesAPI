<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'slug' => $faker->slug,
        'article' => $faker->realText(),

    ];
});
