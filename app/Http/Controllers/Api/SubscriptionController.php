<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'package_name' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'total_sessions' => 'required|integer|min:1',
            ]);

            $subscription = Subscription::create($request->only([
                'student_id',
                'package_name',
                'start_date',
                'end_date',
                'total_sessions'
            ]));

            return response()->json([
                'message' => 'Subscription created successfully',
                'data' => $subscription->load('student')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 'error'
            ], 422);
        }
    }

    public function show(Subscription $subscription): JsonResponse
    {
        $subscription->load('student');

        return response()->json([
            'data' => $subscription
        ]);
    }

    public function use(Subscription $subscription): JsonResponse
    {
        $today = now()->toDateString();
        if ($subscription->start_date->toDateString() > $today || $subscription->end_date->toDateString() < $today) {
            return response()->json([
                'message' => 'Subscription is not active'
            ], 422);
        }

        if ($subscription->total_sessions <= $subscription->used_sessions) {
            return response()->json([
                'message' => 'No sessions remaining'
            ], 422);
        }

        $subscription->increment('used_sessions');

        return response()->json([
            'message' => 'Session used successfully',
            'data' => $subscription->fresh()
        ]);
    }
}
