<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::with(['parent', 'classes'])->get();

        return response()->json([
            'data' => $students
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'current_grade' => 'required|string|max:50',
                'parent_id' => 'required|exists:parents,id',
            ]);

            $student = Student::create($request->only([
                'name',
                'dob',
                'gender',
                'current_grade',
                'parent_id'
            ]));

            $student->load('parent');

            return response()->json([
                'message' => 'Student created successfully',
                'data' => $student
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        }
    }

    public function show(Student $student): JsonResponse
    {
        $student->load(['parent', 'classes', 'subscriptions']);

        return response()->json([
            'data' => $student
        ]);
    }
}
