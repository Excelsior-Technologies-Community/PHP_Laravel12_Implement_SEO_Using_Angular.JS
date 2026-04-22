<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create SEO Page</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; padding: 30px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        label { display:block; margin-top: 15px; font-weight: bold; }
        input[type="text"], textarea { width:100%; padding: 10px; margin-top: 5px; border-radius: 4px; border:1px solid #ccc; }
        button { margin-top: 20px; padding: 10px 20px; border: none; background: #28a745; color: #fff; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        a { display:inline-block; margin-top: 15px; color:#007BFF; }
        a:hover { text-decoration: underline; }
        .alert { padding: 10px; margin-top: 15px; border-radius: 4px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
<div class="container">
    <h2>Create SEO Page</h2>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/admin/store">
        @csrf
        <label>Slug:</label>
        <input type="text" name="slug" required>

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Keywords:</label>
        <input type="text" name="keywords">

        <button type="submit">Save</button>
    </form>

    <a href="/admin">Back</a>
</div>
</body>
</html>