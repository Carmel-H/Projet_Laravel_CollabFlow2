<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editer {{ $task->title }}</title>
</head>
<body>
    <form action="{{ route('tasks.edit', $task->id) }}" method="post">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $task->title }}" required/>
        <textarea name="description" id="description">{{ $task->description }}</textarea>
        <input type="date" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}" required/>
        <select name="status" required>
            <option value="progress" @if ($task->status == 'progress') selected @endif >En cours</option>
            <option value="done" @if ($task->done == 'done') selected @endif >Terminé</option>
            <option value="suspended" @if ($task->suspended == 'suspended') selected @endif >Susdenpu</option>
        </select>
        <button type="submit">Sauver</button>
    </form>
    
</body>
</html>