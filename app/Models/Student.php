<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'gender',
        'current_grade',
        'parent_id',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    public function classRegistrations()
    {
        return $this->hasMany(ClassRegistration::class);
    }

    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'class_registrations',
            'student_id', // this model's key on the pivot table
            'class_id'    // related model's key on the pivot table
        );
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
