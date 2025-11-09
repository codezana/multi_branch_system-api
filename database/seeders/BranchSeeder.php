<?php

namespace Database\Seeders;

use App\Models\Branch;
use Database\Factories\BranchFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::factory()->count(1000)->create();
    }
}
