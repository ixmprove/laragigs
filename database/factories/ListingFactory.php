<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'tags' => $this->getRandomTags(rand(2, 4)),
            'company' => $this->faker->company(),
            'location' => $this->faker->city(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'description' => $this->faker->paragraph(5)
        ];
    }

    private function getRandomTags(int $amount)
    {
        $tag = [
            'javascript',
            'api',
            'backend',
            'frontend',
            'front-end',
            'back-end',
            'linux',
            'devops',
            'php',
            'html',
            'css',
            'react',
            'vue',
            'angular',
            'Java',
            'C++',
            'c#',
            'Python',
            'MongoDB',
            'MySQL',
            'SQL',
            'Express',
            'Node.js',
            'Docker',
            'Bash',
        ];

        $tags = [];

        for ($i = 0; $i < $amount; $i++) {
            $randomTag = $tag[rand(0, count($tag) - 1)];

            if (!in_array($randomTag, $tags)) {
                array_push($tags, $randomTag);
                continue;
            } else {
                $i--;
            }
        };

        return implode(',', $tags);
    }
}
