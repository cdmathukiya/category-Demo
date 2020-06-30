<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        DB::table('category')->insert([
            ['name' => 'PHP', 'slug' => 'php', 'created_at' => $date,'updated_at' => $date],
            ['name' => 'Javascript', 'slug' => 'javascript', 'created_at' => $date,'updated_at' => $date],
            ['name' => 'Java', 'slug' => 'java', 'created_at' => $date,'updated_at' => $date],
        ]);
        
        DB::table('category')->insert([
            ['name' => 'Latavel', 'slug' => 'laravel', 'parent_id' => 1, 'created_at' => $date,'updated_at' => $date],
        ]);

        DB::table('category')->insert([
            ['name' => 'Latavel 7.1', 'slug' => 'laravel7', 'parent_id' => 4, 'created_at' => $date,'updated_at' => $date],
        ]);
    }
}
