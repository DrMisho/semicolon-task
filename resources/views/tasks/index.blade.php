@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<section class="board">
    <header class="board-header">
        <div>
            <p class="eyebrow">Semicolon</p>
            <h1>My Tasks</h1>
            <p class="lede">Add a task, click to complete, or drag it into Completed.</p>
        </div>
    </header>

    <div id="error-banner" class="error-banner" hidden role="alert"></div>

    <form id="task-form" class="composer" autocomplete="off">
        <label class="composer-field" for="task-title">
            <span class="visually-hidden">Task title</span>
            <input
                id="task-title"
                name="title"
                type="text"
                maxlength="100"
                placeholder="What needs doing?"
                required
            >
        </label>
        <button type="submit" class="btn btn-primary">Add task</button>
    </form>

    <div class="columns">
        <section class="column" aria-labelledby="active-heading">
            <div class="column-head">
                <h2 id="active-heading">Active</h2>
                <span id="active-count" class="count-pill">0</span>
            </div>
            <ul id="active-list" class="task-list" data-list="active"></ul>
            <p id="active-empty" class="empty-state">No active tasks yet.</p>
        </section>

        <section
            class="column column-completed"
            aria-labelledby="completed-heading"
            id="completed-dropzone"
        >
            <div class="column-head">
                <h2 id="completed-heading">Completed</h2>
                <span id="completed-count" class="count-pill">0</span>
            </div>
            <ul id="completed-list" class="task-list" data-list="completed"></ul>
            <p id="completed-empty" class="empty-state">Drop a task here, or click one to finish it.</p>
        </section>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/tasks.js') }}" defer></script>
@endpush
