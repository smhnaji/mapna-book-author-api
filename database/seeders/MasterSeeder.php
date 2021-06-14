<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $author = Author::factory()->create();

            for ($j = 0; $j < 100; $j++) {
                Book::factory()->create([
                    'author_id' => $author->id,
                ]);
            }
        }
    }
}
