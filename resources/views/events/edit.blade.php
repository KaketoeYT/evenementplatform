<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required><br><br>

        <label for="datetime">Datetime:</label>
        <input type="datetime-local" name="datetime" id="datetime" value="{{ old('datetime', optional($event->datetime)->format('Y-m-d\TH:i')) }}" required><br><br>

        <label for="duration">Duration (minutes):</label>
        <input type="number" name="duration" id="duration" value="{{ old('duration', $event->duration) }}" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description">{{ old('description', $event->description) }}</textarea><br><br>

        <label for="entry_price">Entry Price:</label>
        <input type="number" step="0.01" name="entry_price" id="entry_price" value="{{ old('entry_price', $event->entry_price) }}" required><br><br>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $event->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select><br><br>

        <label for="venue_id">Venue:</label>
        <select name="venue_id" id="venue_id" required>
            @foreach($venues as $venue)
                <option value="{{ $venue->id }}" @selected(old('venue_id', $event->venue_id) == $venue->id)>{{ $venue->name }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Edit Event</button>
    </form>
</body>
</html>