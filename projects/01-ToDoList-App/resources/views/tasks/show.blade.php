@extends('layouts.app')

@section('title', $task->title)

@section('content')

    <div class="mb-4">
        <a href="{{ route('tasks.index') }}" class="link">
            &#8592; Go back to the task list
        </a>
    </div>

    <p class="mb-4 text-slate-700">{{ $task->description }}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
    @endif

    <p class="mb-4 text-sm text-slate-500">Created on: {{ $task->created_at->toDayDateTimeString() }} -
        Updated: {{ $task->updated_at->diffForHumans() }}</p>

    <p class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
            <span class="font-medium text-red-500">Not completed</span>
        @endif
    </p>

    <div class="flex justify-between">
        <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn hover:bg-blue-300/60">
            Edit
        </a>

        <form action="{{ route('tasks.toggle', ['task' => $task]) }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn hover:bg-yellow-300/60">
                Mark task as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>

        <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn hover:bg-red-300/60">Delete</button>
        </form>
    </div>
@endsection
