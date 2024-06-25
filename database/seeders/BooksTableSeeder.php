<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('books.json'));

        // Decode JSON to associative array
        $data = json_decode($json, true);

        // Insert data into the 'books' table
        foreach ($data as $book) {
            DB::table('books')->insert([
                'name' => $book['name'],
                'description' => $book['description'],
                'price' => $book['price'],
                'cover' => $book['cover'],
            ]);
        }
    }
}
