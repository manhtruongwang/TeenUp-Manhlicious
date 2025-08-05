<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'name' => 'Van Truong',
                'dob' => '2010-03-15',
                'gender' => 'female',
                'current_grade' => '8th Grade',
                'parent_id' => 1,
            ],
            [
                'name' => 'Tuan Nguyen',
                'dob' => '2012-07-22',
                'gender' => 'male',
                'current_grade' => '6th Grade',
                'parent_id' => 2,
            ],
            [
                'name' => 'Thuy Truong',
                'dob' => '2011-11-08',
                'gender' => 'female',
                'current_grade' => '7th Grade',
                'parent_id' => 3,
            ],
            [
                'name' => 'Xuan Nguyen',
                'dob' => '2013-01-30',
                'gender' => 'male',
                'current_grade' => '5th Grade',
                'parent_id' => 4,
            ],
            [
                'name' => 'Tuan Hoang',
                'dob' => '2009-09-12',
                'gender' => 'female',
                'current_grade' => '9th Grade',
                'parent_id' => 5,
            ],
            [
                'name' => 'Hung Truong',
                'dob' => '2014-05-18',
                'gender' => 'male',
                'current_grade' => '4th Grade',
                'parent_id' => 1,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
