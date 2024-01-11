@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('content')

    <form action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}" method="post">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">
                Title
            </label>
            <input type="text" name="title" id="title" @class(['border-red-500 rounded' => $errors->has('title')])
                value="{{ $task->title ?? old('title') }}">
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description">
                Description
            </label>
            <textarea name="description" id="description" cols="15" rows="5" @class(['border-red-500 rounded' => $errors->has('description')])>
                {{ $task->description ?? old('description') }}
            </textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="long_description">
                Long Description
            </label>
            <textarea name="long_description" id="long_description" cols="15" rows="10" @class(['border-red-500 rounded' => $errors->has('long_description')])>
                {{ $task->long_description ?? old('long_description') }}
            </textarea>
            @error('long_description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-between">
            <a href="{{ isset($task) ? route('tasks.show', ['task' => $task]) : route('tasks.index') }}"
                class="btn hover:bg-yellow-300/60">
                @isset($task)
                    &#8592; Go back to the task
                @else
                    &#8592; Go back to the task list
                @endisset
            </a>
            <button type="submit" class="btn hover:bg-green-300/60">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
        </div>
    </form>

@endsection
