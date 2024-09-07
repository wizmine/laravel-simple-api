<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'Lawyer'],
            ['name' => 'Content manager'],
            ['name' => 'Security'],
            ['name' => 'Designer'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
