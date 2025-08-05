<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ClassRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ClassModel $class): JsonResponse
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
            ]);

            $student = Student::findOrFail($request->student_id);

            // Check if class is full
            if ($class->current_students_count >= $class->max_students) {
                return response()->json([
                    'message' => 'Class is full'
                ], 422);
            }

            // Check for schedule conflicts
            $conflictingClass = $student->classes()
                ->where('day_of_week', $class->day_of_week)
                ->where('time_slot', $class->time_slot)
                ->first();

            if ($conflictingClass) {
                return response()->json([
                    'message' => 'Student already has a class at this time slot',
                    'conflicting_class' => $conflictingClass
                ], 422);
            }

            // Check if already registered
            $existingRegistration = ClassRegistration::where('class_id', $class->id)
                ->where('student_id', $student->id)
                ->first();

            if ($existingRegistration) {
                return response()->json([
                    'message' => 'Student is already registered for this class'
                ], 422);
            }

            $registration = ClassRegistration::create([
                'class_id' => $class->id,
                'student_id' => $student->id,
            ]);

            return response()->json([
                'message' => 'Student registered successfully',
                'data' => $registration->load(['class', 'student'])
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
