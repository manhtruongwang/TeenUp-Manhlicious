<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'subject' => 'required|string|max:255',
                'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'time_slot' => 'required|string|max:50',
                'teacher_name' => 'required|string|max:255',
                'max_students' => 'integer|min:1|max:100',
            ]);

            $class = ClassModel::create($validated);

            return response()->json([
                'message' => 'Class created successfully',
                'data' => $class
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $query = ClassModel::query();

        if ($request->has('day')) {
            $query->where('day_of_week', $request->day);
        }

        $classes = $query->withCount('classRegistrations')->get();

        return response()->json([
            'data' => $classes
        ]);
    }
}
