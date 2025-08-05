<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ParentController extends Controller
{
    public function index(): JsonResponse
    {
        $parents = ParentModel::with('students')->get();

        return response()->json([
            'data' => $parents
        ]);
    }

    public function store(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:parents,email',
            ]);
            $parent = ParentModel::create($request->only(['name', 'phone', 'email']));

            return response()->json([
                'message' => 'Parent created successfully',
                'data' => $parent
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        }
    }

    public function show(ParentModel $parent): JsonResponse
    {
        $parent->load('students');

        return response()->json([
            'data' => $parent
        ]);
    }
}
