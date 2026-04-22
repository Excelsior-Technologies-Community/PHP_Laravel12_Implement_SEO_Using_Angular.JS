<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit SEO Page</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        label { display:block; margin-top: 15px; font-weight: bold; }
        input[type="text"], textarea { width:100%; padding: 10px; margin-top: 5px; border-radius: 4px; border:1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 20px; border: none; background: #ffc107; color: #212529; border-radius: 4px; cursor: pointer; }
        button:hover { background: #e0a800; }
        a { display:inline-block; margin-top: 15px; color:#007BFF; }
        a:hover { text-decoration: underline; }
        .alert { padding: 10px; margin-top: 15px; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit SEO Page</h2>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/admin/update/{{ $page->id }}">
        @csrf
        <label>Slug:</label>
        <input type="text" name="slug" value="{{ $page->slug }}" required>

        <label>Title:</label>
        <input type="text" name="title" value="{{ $page->title }}" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required>{{ $page->description }}</textarea>

        <label>Keywords:</label>
        <input type="text" name="keywords" value="{{ $page->keywords }}">

        <button type="submit">Update</button>
    </form>

    <a href="/admin">Back</a>
</div>
</body>
</html>