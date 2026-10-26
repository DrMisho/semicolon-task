<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function board(): View
    {
        return view('tasks.index');
    }

    public function index(Request $request): JsonResponse
    {
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->get(['id', 'title', 'completed', 'created_at']);

        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $request->merge([
            'title' => trim((string) $request->input('title', '')),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $validated['title'],
            'completed' => false,
        ]);

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'completed' => $task->completed,
            'created_at' => $task->created_at,
        ], 201);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        if ($task->user_id !== $request->user()->id) {
            abort(404);
        }

        $task->update(['completed' => true]);

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'completed' => $task->completed,
            'created_at' => $task->created_at,
        ]);
    }
}
