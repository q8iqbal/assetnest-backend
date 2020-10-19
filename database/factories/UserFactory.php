<?php
 
$factory->define(App\User::class, function (Faker\Generator $faker) {
	return [
		'company-id'			=> str_random(32),
        'name'             		=> $faker->name,
        'email'                 => $faker->safeEmail,
        'password'              => \Illuminate\Support\Facades\Hash::make('test-password'),
        'role'                  => \App\Models\User::BASIC_ROLE,
        'picture'          		=> $faker->imageUrl('100')
    ];
});