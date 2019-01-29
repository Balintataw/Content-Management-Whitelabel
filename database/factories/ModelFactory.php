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
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'photo_id' => 1,
        'role_id'=> $faker->numberBetween(1, 3),
        'is_active'=> 1
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->paragraphs(3, true),
        'user_id' => $faker->numberBetween(1, 10),
        'category_id' => $faker->numberBetween(1,5),
        'photo_id' => 1,
        'slug'=> $faker->slug()
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->randomElement(['SUPERUSER', 'ADMIN', 'USER']),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['Religion', 'Politics', 'Frameworks', 'Food', 'Cats']),
    ];
});

$factory->define(App\Photo::class, function (Faker\Generator $faker) {
    return [
        'image_url' => $faker->imageUrl(100, 100, 'cats'),
        'size' => $faker->numberBetween(10, 10000)
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'post_id' => $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1, 10),
        'is_active'=> 1,
        'author' => $faker->name,
        'email' => $faker->safeEmail,
        'content' => $faker->paragraphs(1, true),
    ];
});

$factory->define(App\CommentReply::class, function (Faker\Generator $faker) {
    return [
        'comment_id' => $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1, 10),
        'is_active'=> 1,
        'author' => $faker->name,
        'email' => $faker->safeEmail,
        'content' => $faker->paragraphs(1, true),
    ];
});
