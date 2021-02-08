<?php

namespace Database\Factories\ShortLink;

use App\Models\ShortLink\ShortLink;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ShortLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShortLink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory();
            },
            'link'    => $this->faker->url,
            'code'    => Str::random(8),
        ];
    }
}
