<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParentModel;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = [
            [
                'name' => 'Manh Truong',
                'phone' => '123-456-7890',
                'email' => 'manh.truong@example.com',
            ],
            [
                'name' => 'Linh Nguyen',
                'phone' => '234-567-8901',
                'email' => 'linh.nguyen@example.com',
            ],
            [
                'name' => 'Thai Truong',
                'phone' => '345-678-9012',
                'email' => 'thai.truong@example.com',
            ],
            [
                'name' => 'Lap Nguyen',
                'phone' => '456-789-0123',
                'email' => 'lap.nguyen@example.com',
            ],
            [
                'name' => 'Linh Hoang',
                'phone' => '567-890-1234',
                'email' => 'linh.hoang@example.com',
            ],
        ];

        foreach ($parents as $parent) {
            ParentModel::create($parent);
        }
    }
}
