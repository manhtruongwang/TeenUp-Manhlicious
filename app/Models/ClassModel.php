<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'subject',
        'day_of_week',
        'time_slot',
        'teacher_name',
        'max_students',
    ];

    public function classRegistrations()
    {
        return $this->hasMany(ClassRegistration::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'class_registrations',
            'class_id',   // this model's key on the pivot table
            'student_id'  // related model's key on the pivot table
        );
    }

    public function getCurrentStudentsCountAttribute()
    {
        return $this->classRegistrations()->count();
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->max_students - $this->current_students_count;
    }
}
