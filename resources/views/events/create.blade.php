<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
</head>
<body>
    <h1>Create New Event</h1>
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="datetime">Datetime:</label>
        <input type="datetime-local" name="datetime" id="datetime" required><br><br>

        <label for="duration">Duration (minutes):</label>
        <input type="number" name="duration" id="duration" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea><br><br>

        <label for="entry_price">Entry Price:</label>
        <input type="number" step="0.01" name="entry_price" id="entry_price" required><br><br>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select><br><br>

        <label for="venue_id">Venue:</label>
        <select name="venue_id" id="venue_id" required>
            @foreach($venues as $venue)
                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Create Event</button>
    </form>
</body>
</html>