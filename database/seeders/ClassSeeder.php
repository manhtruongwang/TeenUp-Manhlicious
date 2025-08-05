<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 'Advanced Mathematics',
                'subject' => 'Mathematics',
                'day_of_week' => 'monday',
                'time_slot' => '09:00-10:30',
                'teacher_name' => 'Dr. Manh Truong',
                'max_students' => 15,
            ],
            [
                'name' => 'English Literature',
                'subject' => 'English',
                'day_of_week' => 'monday',
                'time_slot' => '14:00-15:30',
                'teacher_name' => 'Ms. Linh Nguyen',
                'max_students' => 20,
            ],
            [
                'name' => 'Science Lab',
                'subject' => 'Science',
                'day_of_week' => 'tuesday',
                'time_slot' => '10:00-11:30',
                'teacher_name' => 'Mr. Thai Truong',
                'max_students' => 12,
            ],
            [
                'name' => 'History & Geography',
                'subject' => 'Social Studies',
                'day_of_week' => 'tuesday',
                'time_slot' => '15:00-16:30',
                'teacher_name' => 'Dr. Lap Nguyen',
                'max_students' => 18,
            ],
            [
                'name' => 'Computer Programming',
                'subject' => 'Technology',
                'day_of_week' => 'wednesday',
                'time_slot' => '13:00-14:30',
                'teacher_name' => 'Mr. Linh Hoang',
                'max_students' => 10,
            ],
            [
                'name' => 'Art & Creativity',
                'subject' => 'Arts',
                'day_of_week' => 'wednesday',
                'time_slot' => '16:00-17:30',
                'teacher_name' => 'Ms. Xuan Dang',
                'max_students' => 15,
            ],
            [
                'name' => 'Physical Education',
                'subject' => 'Sports',
                'day_of_week' => 'thursday',
                'time_slot' => '11:00-12:30',
                'teacher_name' => 'Coach Minh Tran',
                'max_students' => 25,
            ],
            [
                'name' => 'Music & Instruments',
                'subject' => 'Music',
                'day_of_week' => 'thursday',
                'time_slot' => '14:00-15:30',
                'teacher_name' => 'Ms. Thuy Nguyen',
                'max_students' => 12,
            ],
            [
                'name' => 'Language Learning',
                'subject' => 'Foreign Language',
                'day_of_week' => 'friday',
                'time_slot' => '10:00-11:30',
                'teacher_name' => 'Prof. Manh Truong',
                'max_students' => 16,
            ],
            [
                'name' => 'Study Skills',
                'subject' => 'Academic Support',
                'day_of_week' => 'friday',
                'time_slot' => '15:00-16:30',
                'teacher_name' => 'Ms. Thuy Nguyen',
                'max_students' => 20,
            ],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }
    }
}
