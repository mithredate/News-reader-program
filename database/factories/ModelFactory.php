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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail,
        'password' => '',
        'remember_token' => str_random(10)
    ];
});

$factory->defineAs(App\User::class, 'verified_user', function(\Faker\Generator $faker) use ($factory){
   $user = $factory->raw(\App\User::class);
    return array_merge($user, ['status' => 1]);
});

$factory->defineAs(App\User::class, 'authenticated_user', function(\Faker\Generator $faker) use ($factory){
    $user = $factory->raw(\App\User::class);
    return array_merge($user, [
        'password' => bcrypt(str_random(10)),
        'status' => 2
    ]);
});


$factory->define(App\NewsArticle::class, function (Faker\Generator $faker) {
    $images = array_slice(scandir(storage_path('glide')),2);
    shuffle($images);
    return [
        'title' => $faker->sentence(),
        'photo' => array_shift($images),
        'text' => $faker->paragraph,
        'reporter_email' => function(){
            return factory(\App\User::class,'authenticated_user')->create()->email;
        }
    ];
});
