<?php

namespace Database\Factories;

use App\Models\ShortLink\ShortLink;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'short_link_id' => function () {
                return ShortLink::factory();
            },
            'referer'       => $this->faker->url,
            'ip'            => $this->faker->ipv4,
        ];
    }
}
