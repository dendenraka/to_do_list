<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        DB::table('todo_lists')->insert([
            [
                'title' => 'Belajar Laravel Migration',
                'description' => 'Membuat tabel dengan migration di Laravel',
                'status' => 'To-Do',
                'due_date' => Carbon::now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mengerjakan Proyek To-Do List',
                'description' => 'Membuat CRUD untuk aplikasi To-Do List sederhana',
                'status' => 'In Progress',
                'due_date' => Carbon::now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Upload ke GitHub',
                'description' => 'Push project Laravel ke repository GitHub',
                'status' => 'Done',
                'due_date' => Carbon::now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
